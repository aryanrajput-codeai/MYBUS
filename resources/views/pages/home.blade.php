@extends('layouts.app')

@section('title', 'NANDAN BUS - Online Bus Ticket Booking, Volvo Sleeper & redBus Fares')

@section('content')

<!-- HERO SECTION: redBus Signature Pill Search Bar -->
<section class="relative bg-gradient-to-b from-[#d84e55] to-[#c13b42] text-white pt-14 pb-28 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Subtle Road & Horizon Vector Background -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto text-center relative z-10">
        
        <!-- Tagline / Trust Chip -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold bg-white/20 backdrop-blur-md border border-white/30 text-white uppercase tracking-widest mb-4 shadow-xs">
            <i data-lucide="shield-check" class="w-4 h-4 text-amber-300"></i>
            <span>India's Leading Bus & Holiday Platform</span>
        </div>

        <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold tracking-tight mb-3 leading-tight break-words">
            India's No. 1 Online Bus Ticket Booking Site
        </h1>
        <p class="text-white/90 text-xs sm:text-sm max-w-xl mx-auto mb-10 font-medium">
            Over 100,000+ daily routes across State RTCs and luxury private Volvo 9600 AC sleepers with live seat layout selection.
        </p>

        <!-- THE ICONIC REDBUS PILL SEARCH WIDGET -->
        <div class="bg-white rounded-3xl p-3 sm:p-5 shadow-2xl border border-slate-100 text-slate-800 text-left max-w-5xl mx-auto"
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
            <form action="{{ route('buses.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-2.5 items-center">
                
                <!-- From Input -->
                <div class="md:col-span-4 relative border border-slate-200 rounded-2xl p-3.5 hover:border-[#d84e55] focus-within:border-[#d84e55] focus-within:ring-2 focus-within:ring-red-100 transition bg-slate-50/60">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1.5 mb-1">
                        <i data-lucide="bus" class="w-3.5 h-3.5 text-[#d84e55]"></i> FROM
                    </label>
                    <input type="text" name="from" x-model="from" list="home-from-list" required placeholder="Departure City (e.g. Delhi)"
                           class="w-full text-sm font-extrabold text-slate-900 bg-transparent focus:outline-hidden">
                    <datalist id="home-from-list">
                        @foreach($sourceCities as $c)
                            <option value="{{ $c }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Swap Button (⇄) -->
                <div class="md:col-span-1 flex justify-center -my-2 md:my-0">
                    <button type="button" @click="swap()" title="Swap Cities"
                            class="w-11 h-11 rounded-full bg-white hover:bg-red-50 text-slate-700 hover:text-[#d84e55] flex items-center justify-center border border-slate-200 shadow-md transition transform hover:rotate-180 duration-300">
                        <i data-lucide="arrow-left-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- To Input -->
                <div class="md:col-span-4 relative border border-slate-200 rounded-2xl p-3.5 hover:border-[#d84e55] focus-within:border-[#d84e55] focus-within:ring-2 focus-within:ring-red-100 transition bg-slate-50/60">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1.5 mb-1">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-teal-600"></i> TO
                    </label>
                    <input type="text" name="to" x-model="to" list="home-to-list" required placeholder="Destination City (e.g. Manali)"
                           class="w-full text-sm font-extrabold text-slate-900 bg-transparent focus:outline-hidden">
                    <datalist id="home-to-list">
                        @foreach($destinationCities as $c)
                            <option value="{{ $c }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Date & CTA Column -->
                <div class="md:col-span-3 flex flex-col gap-2">
                    <div class="border border-slate-200 rounded-2xl p-2.5 hover:border-[#d84e55] focus-within:border-[#d84e55] transition bg-slate-50/60">
                        <div class="flex items-center justify-between">
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-amber-500"></i> Date of Journey
                            </label>
                            <div class="flex items-center gap-1">
                                <button type="button" @click="setToday()" class="text-[9px] font-bold px-1.5 py-0.5 bg-slate-200 hover:bg-red-100 hover:text-red-700 rounded text-slate-700 transition">Today</button>
                                <button type="button" @click="setTomorrow()" class="text-[9px] font-bold px-1.5 py-0.5 bg-slate-200 hover:bg-red-100 hover:text-red-700 rounded text-slate-700 transition">Tomorrow</button>
                            </div>
                        </div>
                        <input type="date" name="date" x-model="date" min="{{ date('Y-m-d') }}" required
                               class="w-full text-xs font-extrabold text-slate-900 bg-transparent focus:outline-hidden mt-0.5">
                    </div>

                    <!-- CTA Button -->
                    <button type="submit"
                            class="w-full py-3.5 px-6 bg-[#d84e55] hover:bg-[#c13b42] text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 transition transform active:scale-95">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span>SEARCH BUSES</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Route Suggestions Chips -->
        <div class="mt-6 flex flex-wrap items-center justify-center gap-2 text-xs font-semibold text-white/90">
            <span class="text-white/60">Popular Searches:</span>
            <a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Manali', 'date' => date('Y-m-d')]) }}" class="bg-black/20 hover:bg-black/30 px-3 py-1 rounded-full border border-white/20 transition">Delhi ⇄ Manali</a>
            <a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Jaipur', 'date' => date('Y-m-d')]) }}" class="bg-black/20 hover:bg-black/30 px-3 py-1 rounded-full border border-white/20 transition">Delhi ⇄ Jaipur</a>
            <a href="{{ route('buses.search', ['from' => 'Bangalore', 'to' => 'Goa', 'date' => date('Y-m-d')]) }}" class="bg-black/20 hover:bg-black/30 px-3 py-1 rounded-full border border-white/20 transition">Bangalore ⇄ Goa</a>
            <a href="{{ route('buses.search', ['from' => 'Mumbai', 'to' => 'Pune', 'date' => date('Y-m-d')]) }}" class="bg-black/20 hover:bg-black/30 px-3 py-1 rounded-full border border-white/20 transition">Mumbai ⇄ Pune</a>
        </div>

    </div>
</section>

<!-- TRENDING OFFERS SECTION (redBus Style) -->
<section class="py-12 bg-white" x-data="{ copied: false, copyCode(code) { navigator.clipboard.writeText(code); this.copied = true; setTimeout(() => this.copied = false, 2500); } }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[11px] font-extrabold text-[#d84e55] uppercase tracking-widest block mb-0.5">Exclusive Savings</span>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">TRENDING OFFERS</h2>
            </div>
            <span x-show="copied" x-transition class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200">
                ✓ Coupon Code Copied!
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Offer 1 -->
            <div class="rounded-3xl p-6 bg-gradient-to-br from-red-600 to-rose-700 text-white flex flex-col justify-between shadow-md relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 pointer-events-none"></div>
                <div>
                    <span class="text-[10px] font-extrabold px-2.5 py-1 bg-white/20 rounded-full uppercase tracking-wider inline-block mb-3">BUS TICKETS</span>
                    <h3 class="text-xl font-extrabold leading-snug mb-1">Save up to ₹250 on first bus booking</h3>
                    <p class="text-xs text-white/80">Valid on all private AC sleeper and RTC luxury buses.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/20 flex items-center justify-between">
                    <button type="button" @click="copyCode('FIRST')" class="flex items-center gap-1.5 bg-white text-red-600 font-extrabold text-xs px-3.5 py-1.5 rounded-xl hover:bg-amber-50 transition">
                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        <span>Code: FIRST</span>
                    </button>
                    <span class="text-[11px] text-white/70 font-semibold">Valid till 31 Dec</span>
                </div>
            </div>

            <!-- Offer 2 -->
            <div class="rounded-3xl p-6 bg-gradient-to-br from-slate-900 to-slate-800 text-white flex flex-col justify-between shadow-md relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 pointer-events-none"></div>
                <div>
                    <span class="text-[10px] font-extrabold px-2.5 py-1 bg-amber-400/20 text-amber-300 rounded-full uppercase tracking-wider inline-block mb-3">TOUR PACKAGES</span>
                    <h3 class="text-xl font-extrabold leading-snug mb-1">Flat ₹5,000 Off on Vacation Packages</h3>
                    <p class="text-xs text-slate-300">Applicable on Kashmir, Dubai, Bali and Goa holiday bookings.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-700 flex items-center justify-between">
                    <button type="button" @click="copyCode('NANDAN5000')" class="flex items-center gap-1.5 bg-amber-400 text-slate-950 font-extrabold text-xs px-3.5 py-1.5 rounded-xl hover:bg-amber-300 transition">
                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        <span>Code: NANDAN5000</span>
                    </button>
                    <span class="text-[11px] text-slate-400 font-semibold">Limited Seats</span>
                </div>
            </div>

            <!-- Offer 3 -->
            <div class="rounded-3xl p-6 bg-gradient-to-br from-teal-700 to-emerald-800 text-white flex flex-col justify-between shadow-md relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 pointer-events-none"></div>
                <div>
                    <span class="text-[10px] font-extrabold px-2.5 py-1 bg-white/20 rounded-full uppercase tracking-wider inline-block mb-3">ROUND TRIP SAVINGS</span>
                    <h3 class="text-xl font-extrabold leading-snug mb-1">Flat 15% Off on Return Bus Tickets</h3>
                    <p class="text-xs text-white/80">Save extra on round-trip luxury Volvo and AC sleeper bookings.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/20 flex items-center justify-between">
                    <button type="button" @click="copyCode('RETURN15')" class="flex items-center gap-1.5 bg-white text-teal-800 font-extrabold text-xs px-3.5 py-1.5 rounded-xl hover:bg-emerald-50 transition">
                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        <span>Code: RETURN15</span>
                    </button>
                    <span class="text-[11px] text-white/70 font-semibold">All Routes</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- PRIMO BUSES SECTION: redBus Flagship Quality Standard -->
<section class="py-14 bg-[#f7f7f7] border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-sm">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold bg-blue-50 text-blue-700 border border-blue-200 uppercase tracking-widest mb-3">
                        <i data-lucide="award" class="w-4 h-4 text-blue-600"></i>
                        <span>NANDAN PRIMO GUARANTEE</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-3">
                        Travel with Verified, Top-Rated Primo Buses
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6">
                        Primo brings you handpicked bus operators that maintain strict on-time departure standards, professional 4.5★ certified captains, clean linen, and sanitized sleeper cabins.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800">On-Time Departure Guarantee</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                                <i data-lucide="user-check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800">Top-Rated Captains (4.5★)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                <i data-lucide="sparkles" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800">Sanitized Linen & Pillows</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-red-100 text-red-700 flex items-center justify-center shrink-0">
                                <i data-lucide="navigation-2" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800">Real-Time GPS Tracking</span>
                        </div>
                    </div>
                </div>

                <!-- Primo Badge Illustration Card -->
                <div class="w-full lg:w-96 bg-gradient-to-br from-blue-900 to-indigo-950 text-white rounded-3xl p-6 text-center shadow-xl border border-blue-800 relative">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-600/30 text-amber-400 flex items-center justify-center mb-3">
                        <i data-lucide="crown" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-xl font-extrabold mb-1">Primo Certified Fleet</h3>
                    <p class="text-xs text-blue-200 mb-6">NANDAN Royal Diamond • Zingbus Electric • VRL Platinum</p>
                    
                    <a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Manali', 'date' => date('Y-m-d')]) }}"
                       class="block w-full py-3 bg-white text-blue-950 font-extrabold text-xs rounded-xl hover:bg-blue-50 transition shadow-md">
                        Explore Primo Buses
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- GOVERNMENT RTC PARTNER BADGES -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-8">
            <span class="text-[11px] font-extrabold text-[#d84e55] uppercase tracking-widest block mb-1">Official RTC Partnerships</span>
            <h2 class="text-2xl font-extrabold text-slate-900">Book Official State Roadways Buses</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach([
                ['name' => 'HRTC Himachal', 'state' => 'Shimla / Manali', 'code' => 'HRTC'],
                ['name' => 'UPSRTC Uttar Pradesh', 'state' => 'Agra / Lucknow', 'code' => 'UPSRTC'],
                ['name' => 'RSRTC Rajasthan', 'state' => 'Jaipur / Udaipur', 'code' => 'RSRTC'],
                ['name' => 'KSRTC Karnataka', 'state' => 'Bangalore / Mysore', 'code' => 'KSRTC'],
                ['name' => 'GSRTC Gujarat', 'state' => 'Ahmedabad / Surat', 'code' => 'GSRTC'],
                ['name' => 'APSRTC Andhra', 'state' => 'Tirupati / Vizag', 'code' => 'APSRTC'],
            ] as $rtc)
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 text-center hover:border-red-400 hover:shadow-xs transition group">
                    <div class="w-10 h-10 mx-auto rounded-xl bg-red-100 text-red-700 flex items-center justify-center font-extrabold text-xs mb-2 group-hover:scale-105 transition">
                        {{ $rtc['code'] }}
                    </div>
                    <h4 class="font-bold text-xs text-slate-900 truncate">{{ $rtc['name'] }}</h4>
                    <span class="text-[10px] text-slate-400">{{ $rtc['state'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- POPULAR BUS CORRIDORS & LIVE FARES -->
<section class="py-14 bg-[#f7f7f7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[11px] font-extrabold text-[#d84e55] uppercase tracking-widest block mb-0.5">Top Routes</span>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Popular Bus Routes</h2>
            </div>
            <a href="{{ route('buses.index') }}" class="text-xs font-bold text-[#d84e55] hover:underline flex items-center gap-1">
                View All Routes <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularBusRoutes as $route)
                <a href="{{ route('buses.search', ['from' => $route->source_city, 'to' => $route->destination_city, 'date' => date('Y-m-d')]) }}"
                   class="group bg-white rounded-3xl p-6 border border-slate-200 hover:border-red-400 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold px-3 py-1 bg-red-50 text-red-700 rounded-full border border-red-200">
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
                            <span class="text-[10px] text-slate-400 uppercase font-bold block">Starting From</span>
                            <span class="text-base font-extrabold text-slate-900">₹{{ $route->distance_km > 500 ? '1,499' : ($route->distance_km > 300 ? '899' : '499') }}</span>
                        </div>
                        <span class="text-xs font-extrabold text-[#d84e55] flex items-center gap-1 group-hover:underline">
                            Select Seats <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- TOUR PACKAGES & HOLIDAYS (Preserving ERP capabilities) -->
<section class="py-14 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[11px] font-extrabold text-teal-600 uppercase tracking-widest block mb-0.5">Custom Holidays</span>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Handcrafted Holiday Tour Packages</h2>
            </div>
            <a href="{{ route('packages.index') }}" class="text-xs font-bold text-teal-600 hover:underline flex items-center gap-1">
                Explore All Packages <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredPackages->take(4) as $package)
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl hover:border-teal-400 transition-all duration-300 flex flex-col justify-between group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $package->featured_image }}" alt="{{ $package->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white px-2.5 py-1 rounded-full text-[11px] font-bold">
                            {{ $package->duration_days }}D / {{ $package->duration_nights }}N
                        </div>
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-teal-700 uppercase">{{ $package->destination?->name ?? 'India' }}</span>
                            <h3 class="font-extrabold text-sm text-slate-900 mt-1 line-clamp-2 leading-tight group-hover:text-teal-700 transition">
                                {{ $package->title }}
                            </h3>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Starting Price</span>
                                <span class="text-base font-extrabold text-slate-900">₹{{ number_format($package->starting_price) }}</span>
                            </div>
                            <a href="{{ route('packages.show', $package->slug) }}" class="text-xs font-bold text-teal-600 hover:underline">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- SCALE & STATS STRIP -->
<section class="py-14 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <span class="text-3xl sm:text-4xl font-extrabold text-[#d84e55] block">36M+</span>
                <span class="text-xs text-slate-400 font-semibold uppercase mt-1 block">Happy Travelers</span>
            </div>
            <div>
                <span class="text-3xl sm:text-4xl font-extrabold text-amber-400 block">2,500+</span>
                <span class="text-xs text-slate-400 font-semibold uppercase mt-1 block">Certified Bus Operators</span>
            </div>
            <div>
                <span class="text-3xl sm:text-4xl font-extrabold text-teal-400 block">100,000+</span>
                <span class="text-xs text-slate-400 font-semibold uppercase mt-1 block">Active Bus Routes</span>
            </div>
            <div>
                <span class="text-3xl sm:text-4xl font-extrabold text-emerald-400 block">4.6★</span>
                <span class="text-xs text-slate-400 font-semibold uppercase mt-1 block">Customer Rating</span>
            </div>
        </div>
    </div>
</section>

<!-- FREQUENTLY ASKED QUESTIONS ACCORDION -->
<section class="py-16 bg-[#f7f7f7]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="text-[11px] font-extrabold text-[#d84e55] uppercase tracking-widest block mb-1">Help & Information</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Frequently Asked Questions</h2>
        </div>

        <div class="space-y-3" x-data="{ active: null }">
            @foreach($faqs as $idx => $faq)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
                    <button type="button" @click="active = (active === {{ $idx }} ? null : {{ $idx }})"
                            class="w-full p-5 text-left flex items-center justify-between font-extrabold text-sm text-slate-800 hover:text-[#d84e55] transition">
                        <span>{{ $faq->question }}</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': active === {{ $idx }} }"></i>
                    </button>
                    <div x-show="active === {{ $idx }}" x-transition class="px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
