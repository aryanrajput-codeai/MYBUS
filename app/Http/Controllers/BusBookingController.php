<?php

namespace App\Http\Controllers;

use App\Models\BusOperator;
use App\Models\BusRoute;
use App\Models\BusSchedule;
use App\Models\BusSeatBooking;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BusBookingController extends Controller
{
    /**
     * Bus Ticketing Portal Home (redBus style).
     */
    public function index(): View
    {
        $popularRoutes = BusRoute::where('is_popular', true)->take(6)->get();
        $operators = BusOperator::where('is_active', true)->get();
        $sourceCities = BusRoute::select('source_city')->distinct()->pluck('source_city');
        $destinationCities = BusRoute::select('destination_city')->distinct()->pluck('destination_city');

        return view('pages.buses.index', compact(
            'popularRoutes',
            'operators',
            'sourceCities',
            'destinationCities'
        ));
    }

    /**
     * Search Buses on Route (redBus Results page with filters).
     */
    public function search(Request $request): View
    {
        $from = trim((string) $request->input('from', 'Delhi'));
        $to = trim((string) $request->input('to', 'Manali'));
        $date = $request->input('date', Carbon::today()->toDateString());

        // Find route
        $route = BusRoute::whereRaw('LOWER(source_city) = ?', [strtolower($from)])
            ->whereRaw('LOWER(destination_city) = ?', [strtolower($to)])
            ->first();

        $query = BusSchedule::with(['fleet.operator', 'fleet.seatLayouts', 'boardingPoints', 'droppingPoints'])
            ->where('is_active', true);

        if ($route) {
            $query->where('bus_route_id', $route->id);
        } else {
            // Fallback: match either city or show all active
            $query->whereHas('route', function ($q) use ($from, $to) {
                $q->whereRaw('LOWER(source_city) LIKE ?', ['%'.strtolower($from).'%'])
                    ->orWhereRaw('LOWER(destination_city) LIKE ?', ['%'.strtolower($to).'%']);
            });
        }

        // Filter: Bus Type (AC, Sleeper, Seater)
        if ($request->filled('bus_type')) {
            $busType = $request->input('bus_type');
            $query->whereHas('fleet', function ($q) use ($busType) {
                $q->where('bus_type', 'like', "%{$busType}%");
            });
        }

        // Filter: Operator
        if ($request->filled('operator_id')) {
            $operatorId = $request->input('operator_id');
            $query->whereHas('fleet', function ($q) use ($operatorId) {
                $q->where('bus_operator_id', $operatorId);
            });
        }

        // Filter: Departure Time Slots
        if ($request->filled('time_slot')) {
            $slot = $request->input('time_slot');
            if ($slot === 'before_6am') {
                $query->whereTime('departure_time', '<', '06:00:00');
            } elseif ($slot === '6am_12pm') {
                $query->whereTime('departure_time', '>=', '06:00:00')
                    ->whereTime('departure_time', '<', '12:00:00');
            } elseif ($slot === '12pm_6pm') {
                $query->whereTime('departure_time', '>=', '12:00:00')
                    ->whereTime('departure_time', '<', '18:00:00');
            } elseif ($slot === 'after_6pm') {
                $query->whereTime('departure_time', '>=', '18:00:00');
            }
        }

        // Sort Options
        $sort = $request->input('sort', 'departure_asc');
        if ($sort === 'price_asc') {
            $query->orderBy('base_fare', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('base_fare', 'desc');
        } elseif ($sort === 'rating_desc') {
            $query->join('bus_fleets', 'bus_schedules.bus_fleet_id', '=', 'bus_fleets.id')
                ->join('bus_operators', 'bus_fleets.bus_operator_id', '=', 'bus_operators.id')
                ->orderBy('bus_operators.rating', 'desc')
                ->select('bus_schedules.*');
        } else {
            $query->orderBy('departure_time', 'asc');
        }

        $schedules = $query->get();

        // Calculate available seats count for each schedule on the requested date
        foreach ($schedules as $schedule) {
            $bookedCount = BusSeatBooking::where('bus_schedule_id', $schedule->id)
                ->whereDate('travel_date', $date)
                ->where('status', 'confirmed')
                ->count();
            $schedule->available_seats_count = max(0, $schedule->fleet->total_seats - $bookedCount);
        }

        $operators = BusOperator::where('is_active', true)->get();
        $sourceCities = BusRoute::select('source_city')->distinct()->pluck('source_city');
        $destinationCities = BusRoute::select('destination_city')->distinct()->pluck('destination_city');

        return view('pages.buses.search', compact(
            'from',
            'to',
            'date',
            'route',
            'schedules',
            'operators',
            'sourceCities',
            'destinationCities'
        ));
    }

    /**
     * API: Get Seat Layout & Booked Seats for a Schedule.
     */
    public function getSeats(Request $request, BusSchedule $schedule): JsonResponse
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $fleet = $schedule->fleet()->with('seatLayouts')->first();

        // Already booked seats on this date
        $bookedSeats = BusSeatBooking::where('bus_schedule_id', $schedule->id)
            ->whereDate('travel_date', $date)
            ->where('status', 'confirmed')
            ->pluck('seat_number')
            ->toArray();

        $boardingPoints = $schedule->boardingPoints;
        $droppingPoints = $schedule->droppingPoints;

        $lowerDeck = $fleet->seatLayouts->where('deck', 'lower')->values();
        $upperDeck = $fleet->seatLayouts->where('deck', 'upper')->values();

        return response()->json([
            'schedule_id' => $schedule->id,
            'bus_name' => $fleet->bus_name,
            'bus_type' => $fleet->bus_type,
            'bus_number' => $fleet->bus_number,
            'operator_name' => $fleet->operator->name,
            'sleeper_fare' => $schedule->sleeper_fare,
            'seater_fare' => $schedule->seater_fare,
            'lower_deck' => $lowerDeck,
            'upper_deck' => $upperDeck,
            'booked_seats' => $bookedSeats,
            'boarding_points' => $boardingPoints,
            'dropping_points' => $droppingPoints,
        ]);
    }

    /**
     * Submit Seat Booking & Generate PNR.
     */
    public function bookSeats(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bus_schedule_id' => 'required|exists:bus_schedules,id',
            'travel_date' => 'required|date|after_or_equal:today',
            'seats' => 'required|string', // comma-separated seats e.g. "L1,L2"
            'passenger_name' => 'required|string|max:150',
            'passenger_age' => 'required|integer|min:1|max:120',
            'passenger_gender' => 'required|in:male,female,other',
            'contact_phone' => 'required|string|max:25',
            'contact_email' => 'required|email|max:150',
            'boarding_point' => 'required|string|max:150',
            'dropping_point' => 'required|string|max:150',
            'coupon_code' => 'nullable|string',
        ]);

        $schedule = BusSchedule::with('fleet')->findOrFail($validated['bus_schedule_id']);
        $seatsArray = array_filter(array_map('trim', explode(',', $validated['seats'])));

        if (empty($seatsArray)) {
            return back()->with('error', 'Please select at least one seat to proceed.');
        }

        // Check for double booking
        $alreadyBooked = BusSeatBooking::where('bus_schedule_id', $schedule->id)
            ->whereDate('travel_date', $validated['travel_date'])
            ->whereIn('seat_number', $seatsArray)
            ->where('status', 'confirmed')
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'One or more selected seats have already been booked. Please pick other available seats.');
        }

        $pnr = 'NDN-'.strtoupper(Str::random(7));
        $customer = Auth::check() ? Auth::user()->customer : null;

        $farePerSeat = $schedule->sleeper_fare;
        $gstPerSeat = round($farePerSeat * 0.05, 2); // 5% GST on passenger transport

        // Coupon discount logic
        $discountPerSeat = 0;
        if (! empty($validated['coupon_code'])) {
            $code = strtoupper(trim($validated['coupon_code']));
            if ($code === 'NANDAN5000' || $code === 'WELCOME10') {
                $discountPerSeat = 100.00; // Flat discount
            }
        }

        DB::transaction(function () use ($seatsArray, $schedule, $customer, $pnr, $validated, $farePerSeat, $gstPerSeat, $discountPerSeat) {
            foreach ($seatsArray as $seat) {
                $deck = str_starts_with($seat, 'U') ? 'upper' : 'lower';
                $netSeatFare = max(0, $farePerSeat - $discountPerSeat);
                $totalSeat = $netSeatFare + $gstPerSeat;

                BusSeatBooking::create([
                    'bus_schedule_id' => $schedule->id,
                    'customer_id' => $customer ? $customer->id : null,
                    'pnr_number' => $pnr,
                    'travel_date' => $validated['travel_date'],
                    'seat_number' => $seat,
                    'deck' => $deck,
                    'seat_type' => 'sleeper',
                    'passenger_name' => $validated['passenger_name'],
                    'passenger_age' => $validated['passenger_age'],
                    'passenger_gender' => $validated['passenger_gender'],
                    'contact_phone' => $validated['contact_phone'],
                    'contact_email' => $validated['contact_email'],
                    'boarding_point' => $validated['boarding_point'],
                    'dropping_point' => $validated['dropping_point'],
                    'seat_fare' => $netSeatFare,
                    'gst_amount' => $gstPerSeat,
                    'total_fare' => $totalSeat,
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                ]);
            }
        });

        return redirect()->route('buses.confirmation', ['pnr' => $pnr])
            ->with('success', "Booking confirmed! Your redBus-style M-Ticket PNR is {$pnr}.");
    }

    /**
     * M-Ticket Confirmation & Printable Boarding Pass.
     */
    public function confirmation(string $pnr): View
    {
        $bookings = BusSeatBooking::with(['schedule.fleet.operator', 'schedule.route'])
            ->where('pnr_number', $pnr)
            ->get();

        if ($bookings->isEmpty()) {
            abort(404, 'Bus booking not found.');
        }

        $firstBooking = $bookings->first();
        $schedule = $firstBooking->schedule;
        $operator = $schedule->fleet->operator;
        $seatsList = $bookings->pluck('seat_number')->join(', ');
        $totalAmount = $bookings->sum('total_fare');
        $gstAmount = $bookings->sum('gst_amount');

        return view('pages.buses.confirmation', compact(
            'pnr',
            'bookings',
            'firstBooking',
            'schedule',
            'operator',
            'seatsList',
            'totalAmount',
            'gstAmount'
        ));
    }

    /**
     * Live GPS Bus Tracking simulator page.
     */
    public function track(string $pnr): View
    {
        $booking = BusSeatBooking::with(['schedule.fleet.operator', 'schedule.route'])
            ->where('pnr_number', $pnr)
            ->firstOrFail();

        return view('pages.buses.track', compact('booking'));
    }
}
