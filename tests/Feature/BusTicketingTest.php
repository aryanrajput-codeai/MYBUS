<?php

namespace Tests\Feature;

use App\Models\BusFleet;
use App\Models\BusOperator;
use App\Models\BusPoint;
use App\Models\BusRoute;
use App\Models\BusSchedule;
use App\Models\BusSeatBooking;
use App\Models\BusSeatLayout;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusTicketingTest extends TestCase
{
    use RefreshDatabase;

    protected BusSchedule $schedule;

    protected BusRoute $route;

    protected function setUp(): void
    {
        parent::setUp();

        $operator = BusOperator::create([
            'name' => 'NANDAN TOURS Luxury Fleet',
            'code' => 'NANDAN-FLEET',
            'logo' => 'https://example.com/logo.png',
            'rating' => 4.9,
            'total_reviews' => 120,
            'contact_phone' => '+91 11 4567 8900',
            'contact_email' => 'support@nandantours.com',
            'is_active' => true,
        ]);

        $this->route = BusRoute::create([
            'source_city' => 'Delhi',
            'destination_city' => 'Manali',
            'distance_km' => 540,
            'estimated_duration' => '12h 00m',
            'is_popular' => true,
        ]);

        $fleet = BusFleet::create([
            'bus_operator_id' => $operator->id,
            'bus_number' => 'DL 01 AB 7788',
            'bus_name' => 'NANDAN Royal Diamond 9600 Multi-Axle',
            'bus_type' => 'Volvo 9600 AC Sleeper (2+1)',
            'deck_type' => 'double',
            'total_seats' => 36,
            'amenities' => ['WiFi', 'Charging Point', 'Blanket'],
            'is_active' => true,
        ]);

        BusSeatLayout::create([
            'bus_fleet_id' => $fleet->id,
            'deck' => 'lower',
            'row_num' => 1,
            'col_num' => 1,
            'seat_number' => 'L1',
            'seat_type' => 'sleeper',
            'is_ladies_quota' => true,
        ]);

        BusSeatLayout::create([
            'bus_fleet_id' => $fleet->id,
            'deck' => 'lower',
            'row_num' => 1,
            'col_num' => 3,
            'seat_number' => 'L2',
            'seat_type' => 'sleeper',
            'is_ladies_quota' => false,
        ]);

        $this->schedule = BusSchedule::create([
            'bus_fleet_id' => $fleet->id,
            'bus_route_id' => $this->route->id,
            'departure_time' => '20:30:00',
            'arrival_time' => '08:30:00',
            'duration' => '12h 00m',
            'base_fare' => 999.00,
            'sleeper_fare' => 1499.00,
            'seater_fare' => 999.00,
            'is_active' => true,
        ]);

        BusPoint::create([
            'bus_schedule_id' => $this->schedule->id,
            'type' => 'boarding',
            'point_name' => 'Kashmere Gate Metro',
            'landmark' => 'Gate 1 Ring Road',
            'point_time' => '20:30',
            'sort_order' => 1,
        ]);

        BusPoint::create([
            'bus_schedule_id' => $this->schedule->id,
            'type' => 'dropping',
            'point_name' => 'Manali Private Bus Stand',
            'landmark' => 'Mall Road',
            'point_time' => '08:30',
            'sort_order' => 1,
        ]);
    }

    public function test_bus_home_page_loads_successfully(): void
    {
        $response = $this->get(route('buses.index'));

        $response->assertStatus(200);
        $response->assertSee('Book Bus Tickets Online');
        $response->assertSee('Delhi');
        $response->assertSee('Manali');
    }

    public function test_bus_search_page_displays_matching_schedules(): void
    {
        $response = $this->get(route('buses.search', [
            'from' => 'Delhi',
            'to' => 'Manali',
            'date' => Carbon::today()->toDateString(),
        ]));

        $response->assertStatus(200);
        $response->assertSee('NANDAN TOURS Luxury Fleet');
        $response->assertSee('Volvo 9600 AC Sleeper (2+1)');
        $response->assertSee('1,499');
    }

    public function test_bus_seat_layout_api_returns_json(): void
    {
        $response = $this->getJson(route('buses.api.seats', [
            'schedule' => $this->schedule->id,
            'date' => Carbon::today()->toDateString(),
        ]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'schedule_id',
            'bus_name',
            'bus_type',
            'sleeper_fare',
            'lower_deck',
            'booked_seats',
            'boarding_points',
            'dropping_points',
        ]);
    }

    public function test_user_can_book_bus_seat_and_receive_pnr(): void
    {
        $travelDate = Carbon::today()->addDays(2)->toDateString();

        $response = $this->post(route('buses.book'), [
            'bus_schedule_id' => $this->schedule->id,
            'travel_date' => $travelDate,
            'seats' => 'L2',
            'passenger_name' => 'Amit Verma',
            'passenger_age' => 29,
            'passenger_gender' => 'male',
            'contact_phone' => '+91 98765 43210',
            'contact_email' => 'amit@example.com',
            'boarding_point' => 'Kashmere Gate Metro (20:30)',
            'dropping_point' => 'Manali Private Bus Stand (08:30)',
            'coupon_code' => 'NANDAN5000',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('bus_seat_bookings', [
            'bus_schedule_id' => $this->schedule->id,
            'seat_number' => 'L2',
            'passenger_name' => 'Amit Verma',
        ]);

        $booking = BusSeatBooking::where('seat_number', 'L2')->first();
        $this->assertNotNull($booking);
        $response->assertRedirect(route('buses.confirmation', $booking->pnr_number));
    }

    public function test_prevents_double_booking_of_same_seat_on_same_date(): void
    {
        $travelDate = Carbon::today()->addDays(2)->toDateString();

        BusSeatBooking::create([
            'bus_schedule_id' => $this->schedule->id,
            'pnr_number' => 'NDN-TEST1',
            'travel_date' => $travelDate,
            'seat_number' => 'L2',
            'deck' => 'lower',
            'seat_type' => 'sleeper',
            'passenger_name' => 'Original Passenger',
            'passenger_age' => 30,
            'passenger_gender' => 'male',
            'contact_phone' => '+91 99999 88888',
            'contact_email' => 'original@example.com',
            'seat_fare' => 1499.00,
            'gst_amount' => 74.95,
            'total_fare' => 1573.95,
            'status' => 'confirmed',
        ]);

        // Attempt second booking for seat L2 on the same date
        $response = $this->post(route('buses.book'), [
            'bus_schedule_id' => $this->schedule->id,
            'travel_date' => $travelDate,
            'seats' => 'L2',
            'passenger_name' => 'Second Passenger',
            'passenger_age' => 25,
            'passenger_gender' => 'male',
            'contact_phone' => '+91 98888 77777',
            'contact_email' => 'second@example.com',
            'boarding_point' => 'Kashmere Gate Metro (20:30)',
            'dropping_point' => 'Manali Private Bus Stand (08:30)',
        ]);

        $response->assertSessionHas('error');
    }

    public function test_confirmation_page_displays_ticket_details(): void
    {
        $booking = BusSeatBooking::create([
            'bus_schedule_id' => $this->schedule->id,
            'pnr_number' => 'NDN-CONFIRM123',
            'travel_date' => Carbon::today()->toDateString(),
            'seat_number' => 'L1',
            'deck' => 'lower',
            'seat_type' => 'sleeper',
            'passenger_name' => 'Sunil Chhetri',
            'passenger_age' => 38,
            'passenger_gender' => 'male',
            'contact_phone' => '+91 98111 22334',
            'contact_email' => 'sunil@example.com',
            'boarding_point' => 'Kashmere Gate Metro',
            'dropping_point' => 'Manali Private Bus Stand',
            'seat_fare' => 1499.00,
            'gst_amount' => 74.95,
            'total_fare' => 1573.95,
            'status' => 'confirmed',
        ]);

        $response = $this->get(route('buses.confirmation', 'NDN-CONFIRM123'));

        $response->assertStatus(200);
        $response->assertSee('NDN-CONFIRM123');
        $response->assertSee('Sunil Chhetri');
        $response->assertSee('L1');
    }

    public function test_live_gps_tracking_page_loads(): void
    {
        $booking = BusSeatBooking::create([
            'bus_schedule_id' => $this->schedule->id,
            'pnr_number' => 'NDN-GPS123',
            'travel_date' => Carbon::today()->toDateString(),
            'seat_number' => 'L1',
            'deck' => 'lower',
            'seat_type' => 'sleeper',
            'passenger_name' => 'Rohan Bopanna',
            'passenger_age' => 42,
            'passenger_gender' => 'male',
            'contact_phone' => '+91 98111 22334',
            'contact_email' => 'rohan@example.com',
            'boarding_point' => 'Kashmere Gate Metro',
            'dropping_point' => 'Manali Private Bus Stand',
            'seat_fare' => 1499.00,
            'gst_amount' => 74.95,
            'total_fare' => 1573.95,
            'status' => 'confirmed',
        ]);

        $response = $this->get(route('buses.track', 'NDN-GPS123'));

        $response->assertStatus(200);
        $response->assertSee('Live Bus Tracking');
        $response->assertSee('NDN-GPS123');
    }
}
