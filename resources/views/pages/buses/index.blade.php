@extends('layouts.app')

@section('title', 'NANDAN BUS - Online Bus Ticket Booking, Volvo Sleeper & Low Fares')

@section('content')
<!-- Hero Search Section (redBus Style) -->
<section class="relative bg-gradient-to-b from-[#d84e55] to-[#c13b42] text-white pt-14 pb-28 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.12),transparent)] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-white/20 backdrop-blur-md border border-white/30 text-white uppercase tracking-widest mb-4 shadow-sm">
            <i data-lucide="bus" class="w-4 h-4 text-amber-300"></i>
            <span>India's Premier Bus Booking Platform</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-4">
            Book Bus Tickets Online with <span class="text-amber-300">Live Seat Selection</span>
        </h1>
        <p class="text-white/90 text-sm sm:text-base max-w-2xl mx-auto mb-10">
            Over 2,500+ daily luxury Volvo 9600 multi-axle AC sleeper buses, electric coaches, and guaranteed sanitized seats across 100,000+ Indian routes.
        </p>

        <!-- redBus Floating Search Widget -->
        <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-2xl border border-slate-100 text-slate-800 text-left max-w-5xl mx-auto"
             x-data="{
                from: 'Delhi',
                to: 'Manali',
                date: '{{ date('Y-m-d') }}',
                swap() {
                    const temp = this.from;
                    this.from = this.to;
                    this.to = temp;
                },
                setToday() {
                    this.date = '{{ date('Y-m-d') }}';
                },
                setTomorrow() {
                    this.date = '{{ date('Y-m-d', strtotime('+1 day')) }}';
                }
             }">
            <form action="{{ route('buses.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                
                <!-- From City -->
                <div class="md:col-span-4 relative border border-slate-200 rounded-2xl p-3 hover:border-red-500 focus-within:border-red-500 focus-within:ring-2 focus-within:ring-red-100 transition bg-slate-50/50">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-3 h-3 text-red-500"></i> From
                    </label>
                    <input type="text" name="from" x-model="from" list="source-cities" required placeholder="Departure City (e.g. Delhi)"
                           class="w-full text-sm font-bold text-slate-900 bg-transparent focus:outline-hidden mt-0.5">
                    <datalist id="source-cities">
                        @foreach($sourceCities as $c)
                            <option value="{{ $c }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Swap Button -->
                <div class="md:col-span-1 flex justify-center -my-2 md:my-0">
                    <button type="button" @click="swap()" title="Swap Departure and Destination"
                            class="w-10 h-10 rounded-full bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-600 flex items-center justify-center border border-slate-200 shadow-sm transition transform hover:rotate-180 duration-200">
                        <i data-lucide="arrow-left-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- To City -->
                <div class="md:col-span-4 relative border border-slate-200 rounded-2xl p-3 hover:border-red-500 focus-within:border-red-500 focus-within:ring-2 focus-within:ring-red-100 transition bg-slate-50/50">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="navigation" class="w-3 h-3 text-teal-600"></i> To
                    </label>
                    <input type="text" name="to" x-model="to" list="destination-cities" required placeholder="Destination City (e.g. Manali)"
                           class="w-full text-sm font-bold text-slate-900 bg-transparent focus:outline-hidden mt-0.5">
                    <datalist id="destination-cities">
                        @foreach($destinationCities as $c)
                            <option value="{{ $c }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Date & Submit Button -->
                <div class="md:col-span-3 flex flex-col gap-2">
                    <div class="border border-slate-200 rounded-2xl p-2.5 hover:border-red-500 focus-within:border-red-500 transition bg-slate-50/50">
                        <div class="flex items-center justify-between">
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3 h-3 text-amber-500"></i> Date of Journey
                            </label>
                            <div class="flex items-center gap-1">
                                <button type="button" @click="setToday()" class="text-[9px] font-bold px-1.5 py-0.5 bg-slate-200 hover:bg-red-100 hover:text-red-700 rounded text-slate-600 transition">Today</button>
                                <button type="button" @click="setTomorrow()" class="text-[9px] font-bold px-1.5 py-0.5 bg-slate-200 hover:bg-red-100 hover:text-red-700 rounded text-slate-600 transition">Tomorrow</button>
                            </div>
                        </div>
                        <input type="date" name="date" x-model="date" min="{{ date('Y-m-d') }}" required
                               class="w-full text-xs font-bold text-slate-900 bg-transparent focus:outline-hidden mt-0.5">
                    </div>

                    <button type="submit"
                            class="w-full py-3.5 px-6 bg-[#d84e55] hover:bg-[#c13b42] text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 transition transform active:scale-95">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span>SEARCH BUSES</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Offers Strip -->
        <div class="mt-6 flex flex-wrap justify-center items-center gap-4 text-xs font-semibold text-white/90">
            <span class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-full border border-white/20">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i> Instant Seat Confirmation
            </span>
            <span class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-full border border-white/20">
                <i data-lucide="badge-percent" class="w-4 h-4 text-amber-300"></i> Use Code: <strong>NANDAN5000</strong>
            </span>
            <span class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-full border border-white/20">
                <i data-lucide="map-pin" class="w-4 h-4 text-teal-300"></i> Live GPS Bus Tracking
            </span>
        </div>
    </div>
</section>

<!-- Popular Bus Routes Grid -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-extrabold text-red-600 uppercase tracking-widest block mb-1">Top Bus Corridors</span>
                <h2 class="text-3xl font-extrabold text-slate-900">Popular Intercity Bus Routes</h2>
            </div>
            <p class="text-xs text-slate-500 max-w-sm">
                Daily departure luxury Volvo, Scania, and electric sleeper buses on India's busiest tourism and commercial expressways.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularRoutes as $route)
                <a href="{{ route('buses.search', ['from' => $route->source_city, 'to' => $route->destination_city, 'date' => date('Y-m-d')]) }}"
                   class="group bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-red-400 hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold px-2.5 py-1 bg-red-50 text-red-700 rounded-lg border border-red-200">
                                {{ $route->estimated_duration }}
                            </span>
                            <span class="text-xs text-slate-400 font-semibold">{{ $route->distance_km }} km</span>
                        </div>
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-red-600 transition">
                                {{ $route->source_city }}
                            </h3>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-400 group-hover:translate-x-1 group-hover:text-red-500 transition-transform"></i>
                            <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-red-600 transition">
                                {{ $route->destination_city }}
                            </h3>
                        </div>
                        <p class="text-xs text-slate-500">
                            Volvo 9600 AC Sleeper • Scania Multi-Axle • Electric AC
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-bold block">Fares starting from</span>
                            <span class="text-base font-extrabold text-slate-900">₹{{ $route->distance_km > 500 ? '1,499' : ($route->distance_km > 300 ? '899' : '499') }}</span>
                        </div>
                        <span class="text-xs font-extrabold text-red-600 flex items-center gap-1 group-hover:underline">
                            Select Seats <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Certified Bus Operators Showcase -->
<section class="py-16 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-extrabold text-red-600 uppercase tracking-widest block mb-1">Partner Operators</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mb-3">Partnered with India's Top Bus Fleets</h2>
            <p class="text-sm text-slate-600">
                Over 2,500+ verified bus operators offering sanitized blankets, on-time punctuality guarantee, and GPS live tracking.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($operators as $op)
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 text-center hover:shadow-md transition">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-white shadow-sm flex items-center justify-center p-2 mb-3 border border-slate-200">
                        <img src="{{ $op->logo }}" alt="{{ $op->name }}" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <h3 class="font-extrabold text-xs text-slate-900 truncate" title="{{ $op->name }}">{{ $op->name }}</h3>
                    <div class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-600 mt-1">
                        <i data-lucide="star" class="w-3 h-3 fill-amber-500 text-amber-500"></i>
                        <span>{{ number_format($op->rating, 1) }}</span>
                        <span class="text-[10px] text-slate-400">({{ $op->total_reviews }})</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Amenities & Trust Badges -->
<section class="py-16 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-600/20 text-red-400 flex items-center justify-center shrink-0 border border-red-500/30">
                    <i data-lucide="armchair" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-base mb-1">Select Exact Seats</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Choose upper or lower sleeper berths with interactive deck diagrams.</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-600/20 text-amber-400 flex items-center justify-center shrink-0 border border-amber-500/30">
                    <i data-lucide="navigation-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-base mb-1">Live Bus Tracking</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Know where your bus is and share live tracking links with family.</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-600/20 text-teal-400 flex items-center justify-center shrink-0 border border-teal-500/30">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-base mb-1">Ladies Reserved Quota</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Dedicated safe seating for female passengers traveling solo.</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/30">
                    <i data-lucide="smartphone" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-base mb-1">Paperless M-Ticket</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Instant SMS, WhatsApp & scannable QR ticket directly on your phone.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
