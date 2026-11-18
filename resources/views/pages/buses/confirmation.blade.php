@extends('layouts.app')

@section('title', "Booking Confirmed - M-Ticket {$pnr} | NANDAN BUS")

@section('content')
<div class="py-12 bg-slate-100 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        
        <!-- Success Alert Header -->
        <div class="bg-emerald-600 text-white rounded-3xl p-6 sm:p-8 mb-6 text-center shadow-lg shadow-emerald-600/20 relative overflow-hidden">
            <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-3">
                <i data-lucide="check-check" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold mb-1">Ticket Confirmed Successfully!</h1>
            <p class="text-emerald-100 text-xs sm:text-sm">
                Your bus reservation has been secured. An instant M-Ticket has been sent to {{ $firstBooking->contact_phone }}.
            </p>
            <div class="mt-4 inline-flex items-center gap-2 bg-white/20 px-4 py-1.5 rounded-full text-xs font-mono font-bold tracking-wider">
                <span>PNR: {{ $pnr }}</span>
            </div>
        </div>

        <!-- redBus Digital M-Ticket Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden print:border-none print:shadow-none" id="printable-ticket">
            
            <!-- Ticket Top Brand Bar -->
            <div class="bg-slate-900 text-white p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-600 flex items-center justify-center text-white font-bold">
                        <i data-lucide="bus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base leading-tight">{{ $operator->name }}</h2>
                        <p class="text-xs text-slate-400">{{ $schedule->fleet->bus_type }} • {{ $schedule->fleet->bus_number }}</p>
                    </div>
                </div>

                <div class="text-center sm:text-right">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Boarding Pass PNR</span>
                    <span class="text-lg font-mono font-extrabold text-amber-400">{{ $pnr }}</span>
                </div>
            </div>

            <!-- Route Timeline -->
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center justify-between gap-4">
                    <!-- Origin -->
                    <div class="text-left">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Departure</span>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900 block mt-0.5">
                            {{ date('h:i A', strtotime($schedule->departure_time)) }}
                        </span>
                        <h3 class="font-extrabold text-slate-800 text-sm mt-1">{{ $schedule->route->source_city }}</h3>
                        <p class="text-xs text-slate-500 max-w-[200px]">{{ $firstBooking->boarding_point }}</p>
                    </div>

                    <!-- Duration Badge -->
                    <div class="text-center px-4">
                        <span class="text-xs font-bold text-slate-500 bg-slate-200/80 px-2.5 py-1 rounded-full">
                            {{ $schedule->duration }}
                        </span>
                        <div class="w-24 sm:w-36 h-0.5 bg-slate-300 relative my-2">
                            <i data-lucide="bus" class="w-4 h-4 text-red-600 absolute -top-2 left-1/2 -translate-x-1/2"></i>
                        </div>
                        <span class="text-[10px] text-slate-400 font-semibold block">Date: {{ date('D, d M Y', strtotime($firstBooking->travel_date)) }}</span>
                    </div>

                    <!-- Destination -->
                    <div class="text-right">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Arrival</span>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900 block mt-0.5">
                            {{ date('h:i A', strtotime($schedule->arrival_time)) }}
                        </span>
                        <h3 class="font-extrabold text-slate-800 text-sm mt-1">{{ $schedule->route->destination_city }}</h3>
                        <p class="text-xs text-slate-500 max-w-[200px]">{{ $firstBooking->dropping_point }}</p>
                    </div>
                </div>
            </div>

            <!-- Passenger & Seat Allocation -->
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-slate-100">
                <div>
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-2">Passenger Information</span>
                    <div class="space-y-2">
                        @foreach($bookings as $booking)
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <div>
                                    <span class="font-extrabold text-slate-900 block">{{ $booking->passenger_name }}</span>
                                    <span class="text-[11px] text-slate-500 capitalize">{{ $booking->passenger_gender }}, {{ $booking->passenger_age }} yrs</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-slate-400 font-bold block uppercase">Seat No.</span>
                                    <span class="text-sm font-extrabold px-2 py-0.5 bg-red-50 text-red-700 rounded-lg border border-red-200">
                                        {{ $booking->seat_number }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Fare & GST Summary -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 text-xs space-y-2 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-2">Fare Breakdown</span>
                        <div class="flex justify-between text-slate-600">
                            <span>Seats Booked:</span>
                            <span class="font-bold text-slate-900">{{ $seatsList }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Base Passenger Fare:</span>
                            <span>₹{{ number_format($totalAmount - $gstAmount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>GST (SAC 998555 @ 5%):</span>
                            <span>₹{{ number_format($gstAmount, 2) }}</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex justify-between items-center text-sm">
                        <span class="font-extrabold text-slate-900">Total Paid:</span>
                        <span class="font-extrabold text-emerald-600 text-base">₹{{ number_format($totalAmount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Scannable QR & Verification -->
            <div class="p-6 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-4">
                    <!-- Stylized QR Display -->
                    <div class="w-16 h-16 bg-white border border-slate-300 rounded-xl p-1 shadow-xs flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(route('buses.track', $pnr)) }}" alt="QR Code" class="w-full h-full">
                    </div>
                    <div>
                        <span class="font-bold text-slate-800 block">Scan to Board Bus</span>
                        <span class="text-[11px] text-slate-400">Show this QR or PNR to the bus captain during boarding.</span>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-[11px] font-bold text-slate-700 block">24x7 Bus Support:</span>
                    <span class="text-xs font-extrabold text-slate-900">{{ $operator->contact_phone }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Print / Track / Back) -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 print:hidden">
            <a href="{{ route('buses.track', $pnr) }}"
               class="w-full sm:w-auto px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center justify-center gap-2">
                <i data-lucide="navigation" class="w-4 h-4 text-amber-400"></i>
                <span>Track Bus Live (GPS)</span>
            </a>

            <button type="button" onclick="window.print()"
                    class="w-full sm:w-auto px-6 py-3 bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                <span>Print M-Ticket</span>
            </button>

            <a href="{{ route('buses.index') }}"
               class="w-full sm:w-auto px-6 py-3 bg-red-50 hover:bg-red-100 text-red-700 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Book Another Bus</span>
            </a>
        </div>
    </div>
</div>
@endsection
