@extends('layouts.app')

@section('title', "{$from} to {$to} Bus Tickets - Online Booking | NANDAN BUS")

@section('content')
<!-- DESKTOP Modify Route & Date Search Bar (redBus Top Strip) -->
<div class="hidden lg:block bg-gradient-to-r from-[#d84e55] to-[#c13b42] text-white py-4 px-4 sm:px-6 lg:px-8 shadow-sm relative z-20">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        
        <form action="{{ route('buses.search') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
            <!-- From City -->
            <div class="bg-white/10 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/20 flex items-center gap-2 text-xs flex-1 sm:flex-none">
                <i data-lucide="bus" class="w-4 h-4 text-amber-300 shrink-0"></i>
                <div class="min-w-0">
                    <span class="block text-[9px] uppercase font-extrabold text-white/70 leading-none">From</span>
                    <input type="text" name="from" value="{{ $from }}" list="search-from-list" required
                           class="bg-transparent text-white font-extrabold placeholder-white/60 focus:outline-hidden w-28 sm:w-36 text-xs mt-0.5">
                </div>
                <datalist id="search-from-list">
                    @foreach($sourceCities as $c)
                        <option value="{{ $c }}"></option>
                    @endforeach
                </datalist>
            </div>

            <i data-lucide="arrow-right" class="w-4 h-4 text-white/60 hidden sm:block"></i>

            <!-- To City -->
            <div class="bg-white/10 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/20 flex items-center gap-2 text-xs flex-1 sm:flex-none">
                <i data-lucide="map-pin" class="w-4 h-4 text-teal-300 shrink-0"></i>
                <div class="min-w-0">
                    <span class="block text-[9px] uppercase font-extrabold text-white/70 leading-none">To</span>
                    <input type="text" name="to" value="{{ $to }}" list="search-to-list" required
                           class="bg-transparent text-white font-extrabold placeholder-white/60 focus:outline-hidden w-28 sm:w-36 text-xs mt-0.5">
                </div>
                <datalist id="search-to-list">
                    @foreach($destinationCities as $c)
                        <option value="{{ $c }}"></option>
                    @endforeach
                </datalist>
            </div>

            <!-- Date -->
            <div class="bg-white/10 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/20 flex items-center gap-2 text-xs flex-1 sm:flex-none">
                <i data-lucide="calendar" class="w-4 h-4 text-amber-300 shrink-0"></i>
                <div class="min-w-0">
                    <span class="block text-[9px] uppercase font-extrabold text-white/70 leading-none">Date</span>
                    <input type="date" name="date" value="{{ $date }}" min="{{ date('Y-m-d') }}" required
                           class="bg-transparent text-white font-extrabold focus:outline-hidden text-xs mt-0.5">
                </div>
            </div>

            <button type="submit" class="px-5 py-3 bg-white text-[#d84e55] hover:bg-amber-50 font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-1.5 shrink-0">
                <i data-lucide="search" class="w-4 h-4"></i>
                <span>MODIFY</span>
            </button>
        </form>

        <div class="text-xs font-semibold text-white/90 hidden lg:flex items-center gap-3">
            <span class="bg-white/20 px-3 py-1.5 rounded-full text-white font-extrabold">
                {{ $schedules->count() }} Buses Available
            </span>
            <span>Distance: {{ $route?->distance_km ?? 350 }} km</span>
        </div>
    </div>
</div>

<!-- NATIVE MOBILE APP BAR (redBus Mobile App Style) -->
<div class="lg:hidden sticky top-0 z-30 bg-[#d84e55] text-white px-4 py-3 shadow-md flex items-center justify-between"
     x-data="{ mobileSearchOpen: false }">
    <div class="flex items-center gap-3">
        <a href="{{ route('buses.index') }}" class="p-1 -ml-1 text-white/90 hover:text-white">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <div class="flex items-center gap-1.5 text-sm font-black leading-tight">
                <span>{{ $from }}</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 opacity-80"></i>
                <span>{{ $to }}</span>
            </div>
            <span class="text-[11px] text-white/80 font-semibold block">{{ date('D, d M', strtotime($date)) }} • {{ $schedules->count() }} Buses Available</span>
        </div>
    </div>
    
    <div class="flex items-center gap-2">
        <button type="button" @click="mobileSearchOpen = !mobileSearchOpen"
                class="px-2.5 py-1.5 bg-white/20 hover:bg-white/30 rounded-xl text-white font-black text-xs flex items-center gap-1 border border-white/20">
            <i data-lucide="search" class="w-3.5 h-3.5"></i>
            <span>Edit</span>
        </button>
    </div>

    <!-- Mobile Slide-Down Quick Search Modal -->
    <div x-show="mobileSearchOpen" @click.outside="mobileSearchOpen = false" x-transition
         class="fixed inset-x-0 top-14 bg-white text-slate-800 p-4 shadow-2xl border-b border-slate-200 z-40">
        <form action="{{ route('buses.search') }}" method="GET" class="space-y-3">
            <div>
                <label class="block text-[10px] font-extrabold uppercase text-slate-400">From City</label>
                <input type="text" name="from" value="{{ $from }}" list="m-search-from-list" required
                       class="w-full text-xs font-bold p-2.5 rounded-xl border border-slate-300">
                <datalist id="m-search-from-list">
                    @foreach($sourceCities as $c)
                        <option value="{{ $c }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-[10px] font-extrabold uppercase text-slate-400">To City</label>
                <input type="text" name="to" value="{{ $to }}" list="m-search-to-list" required
                       class="w-full text-xs font-bold p-2.5 rounded-xl border border-slate-300">
                <datalist id="m-search-to-list">
                    @foreach($destinationCities as $c)
                        <option value="{{ $c }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-[10px] font-extrabold uppercase text-slate-400">Date</label>
                <input type="date" name="date" value="{{ $date }}" min="{{ date('Y-m-d') }}" required
                       class="w-full text-xs font-bold p-2.5 rounded-xl border border-slate-300">
            </div>
            <button type="submit" class="w-full py-3 bg-[#d84e55] text-white font-black text-xs rounded-xl shadow-md">
                SEARCH BUSES
            </button>
        </form>
    </div>
</div>

<!-- NATIVE MOBILE HORIZONTAL DATE SCROLLER STRIP -->
<div class="lg:hidden bg-white border-b border-slate-200 overflow-x-auto py-2.5 px-3 flex items-center gap-2 text-xs scrollbar-none shadow-2xs">
    @php
        $selectedDateObj = \Carbon\Carbon::parse($date);
    @endphp
    @for($offset = -1; $offset <= 5; $offset++)
        @php
            $targetDate = $selectedDateObj->copy()->addDays($offset);
            $isSelected = $targetDate->toDateString() === $date;
            $dayLabel = $offset === 0 ? 'Selected' : ($targetDate->isToday() ? 'Today' : ($targetDate->isTomorrow() ? 'Tomorrow' : $targetDate->format('D')));
        @endphp
        <a href="{{ route('buses.search', ['from' => $from, 'to' => $to, 'date' => $targetDate->toDateString()]) }}"
           class="px-3.5 py-1.5 rounded-xl text-center shrink-0 transition {{ $isSelected ? 'bg-[#d84e55] text-white font-black shadow-xs ring-2 ring-red-300' : 'bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200' }}">
            <span class="block text-[10px] uppercase tracking-wider leading-none">{{ $dayLabel }}</span>
            <span class="block text-xs font-extrabold leading-tight mt-1">{{ $targetDate->format('d M') }}</span>
        </a>
    @endfor
</div>

@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 text-xs sm:text-sm rounded-r flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

<!-- Search Results & Filters Section -->
<section class="py-6 sm:py-8 bg-[#f7f7f7] min-h-screen" x-data="{ mobileFiltersOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Mobile Filter Toggle Bar -->
        <div class="lg:hidden mb-4 flex items-center justify-between bg-white p-3 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="text-xs font-extrabold text-slate-800 flex items-center gap-2">
                <i data-lucide="bus" class="w-4 h-4 text-[#d84e55]"></i>
                <span>{{ $schedules->count() }} Buses Available</span>
            </div>
            <button type="button" @click="mobileFiltersOpen = !mobileFiltersOpen"
                    class="px-3.5 py-1.5 bg-red-50 text-[#d84e55] font-extrabold text-xs rounded-xl border border-red-200 flex items-center gap-1.5">
                <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5"></i>
                <span x-text="mobileFiltersOpen ? 'Close Filter' : 'Filter & Sort'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
            
            <!-- LEFT FILTERS SIDEBAR (redBus Style) -->
            <aside :class="mobileFiltersOpen ? 'block' : 'hidden lg:block'"
                   class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs lg:sticky lg:top-24 space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 text-[#d84e55]"></i> FILTERS
                    </h3>
                    <a href="{{ route('buses.search', ['from' => $from, 'to' => $to, 'date' => $date]) }}" class="text-[11px] font-extrabold text-[#d84e55] hover:underline">
                        CLEAR ALL
                    </a>
                </div>

                <!-- Departure Time Slots -->
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider mb-2.5">Departure Time</label>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['time_slot' => 'before_6am']) }}"
                           class="p-2.5 rounded-2xl border text-center transition font-semibold {{ request('time_slot') == 'before_6am' ? 'bg-red-50 border-[#d84e55] text-[#d84e55] font-extrabold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                            <i data-lucide="sunrise" class="w-4 h-4 mx-auto mb-1 text-amber-500"></i>
                            <span class="block text-[10px]">Before 6 AM</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['time_slot' => '6am_12pm']) }}"
                           class="p-2.5 rounded-2xl border text-center transition font-semibold {{ request('time_slot') == '6am_12pm' ? 'bg-red-50 border-[#d84e55] text-[#d84e55] font-extrabold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                            <i data-lucide="sun" class="w-4 h-4 mx-auto mb-1 text-amber-500"></i>
                            <span class="block text-[10px]">6 AM - 12 PM</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['time_slot' => '12pm_6pm']) }}"
                           class="p-2.5 rounded-2xl border text-center transition font-semibold {{ request('time_slot') == '12pm_6pm' ? 'bg-red-50 border-[#d84e55] text-[#d84e55] font-extrabold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                            <i data-lucide="sunset" class="w-4 h-4 mx-auto mb-1 text-orange-500"></i>
                            <span class="block text-[10px]">12 PM - 6 PM</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['time_slot' => 'after_6pm']) }}"
                           class="p-2.5 rounded-2xl border text-center transition font-semibold {{ request('time_slot') == 'after_6pm' ? 'bg-red-50 border-[#d84e55] text-[#d84e55] font-extrabold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                            <i data-lucide="moon" class="w-4 h-4 mx-auto mb-1 text-indigo-500"></i>
                            <span class="block text-[10px]">After 6 PM</span>
                        </a>
                    </div>
                </div>

                <!-- Bus Fleet Type -->
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider mb-2.5">Bus Type</label>
                    <div class="space-y-1.5 text-xs font-semibold text-slate-700">
                        <a href="{{ request()->fullUrlWithQuery(['bus_type' => 'Sleeper']) }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 {{ request('bus_type') == 'Sleeper' ? 'bg-red-50 text-[#d84e55] font-extrabold' : '' }}">
                            <span>AC Sleeper (2+1)</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['bus_type' => 'Volvo']) }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 {{ request('bus_type') == 'Volvo' ? 'bg-red-50 text-[#d84e55] font-extrabold' : '' }}">
                            <span>Volvo 9600 Luxury</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['bus_type' => 'Electric']) }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 {{ request('bus_type') == 'Electric' ? 'bg-red-50 text-[#d84e55] font-extrabold' : '' }}">
                            <span>Electric Eco-Sleeper</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Bus Operators Checklist -->
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider mb-2.5">Operators</label>
                    <div class="space-y-1 text-xs">
                        @foreach($operators as $op)
                            <a href="{{ request()->fullUrlWithQuery(['operator_id' => $op->id]) }}"
                               class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 {{ request('operator_id') == $op->id ? 'bg-red-50 text-[#d84e55] font-extrabold' : 'text-slate-700' }}">
                                <span class="truncate">{{ $op->name }}</span>
                                <span class="text-[10px] text-amber-600 font-extrabold">★ {{ $op->rating }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Sorting Dropdown -->
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-800 uppercase tracking-wider mb-2">Sort Results</label>
                    <select onchange="window.location.href = this.value" class="w-full text-xs font-semibold p-2.5 rounded-xl border border-slate-300 bg-white">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'departure_asc']) }}" {{ request('sort') == 'departure_asc' ? 'selected' : '' }}>Departure: Earliest First</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Fare: Lowest to Highest</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Fare: Highest to Lowest</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating_desc']) }}" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Customer Rating</option>
                    </select>
                </div>
            </aside>

            <!-- CENTER BUS RESULTS LIST -->
            <main class="lg:col-span-3 space-y-5">
                @if($schedules->isEmpty())
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-50 text-[#d84e55] rounded-full flex items-center justify-center">
                            <i data-lucide="bus" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 mb-2">No Buses Found For {{ $from }} to {{ $to }}</h3>
                        <p class="text-xs text-slate-500 mb-6 max-w-md mx-auto">
                            Try checking dates for Delhi ⇄ Manali, Delhi ⇄ Jaipur, Bangalore ⇄ Goa, Mumbai ⇄ Pune, or Bangalore ⇄ Hyderabad.
                        </p>
                        <a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Manali', 'date' => $date]) }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-[#d84e55] hover:bg-[#c13b42] text-white font-extrabold text-xs rounded-xl shadow-md transition">
                            <i data-lucide="sparkles" class="w-4 h-4"></i> View Delhi to Manali Buses
                        </a>
                    </div>
                @else
                    @foreach($schedules as $schedule)
                        @php
                            $fleet = $schedule->fleet;
                            $operator = $fleet->operator;
                            $bookedSeatsList = \App\Models\BusSeatBooking::where('bus_schedule_id', $schedule->id)
                                ->whereDate('travel_date', $date)
                                ->where('status', 'confirmed')
                                ->pluck('seat_number')
                                ->toArray();
                            $baseFare = (int) $schedule->sleeper_fare;
                            $lowerLayout = $fleet->seatLayouts->where('deck', 'lower')->groupBy('row_num');
                            $upperLayout = $fleet->seatLayouts->where('deck', 'upper')->groupBy('row_num');
                        @endphp
                        
                        <!-- Authentic redBus Bus Card Component -->
                        <div x-data="{
                                openSeats: false,
                                step: 1, // 1: Select seats, 2: Board/Drop point, 3: Passenger Info
                                mobileDeck: 'lower', // 'lower' or 'upper' for mobile view
                                mobilePointTab: 'boarding', // 'boarding' or 'dropping' for mobile step 2
                                rightTab: 'highlights', // 'highlights', 'cancellation', 'reschedule', 'route', 'boarding'
                                selectedSeats: [],
                                seatPrices: {},
                                boardingPoint: '{{ $schedule->boardingPoints->first()?->point_name }} ({{ $schedule->boardingPoints->first()?->point_time }})',
                                droppingPoint: '{{ $schedule->droppingPoints->first()?->point_name }} ({{ $schedule->droppingPoints->first()?->point_time }})',
                                discountPerSeat: 100,

                                toggleSeat(seatNum, price, isBooked) {
                                    if (isBooked) return;
                                    const index = this.selectedSeats.indexOf(seatNum);
                                    if (index > -1) {
                                        this.selectedSeats.splice(index, 1);
                                        delete this.seatPrices[seatNum];
                                    } else {
                                        if (this.selectedSeats.length >= 6) {
                                            alert('Maximum 6 seats per booking allowed.');
                                            return;
                                        }
                                        this.selectedSeats.push(seatNum);
                                        this.seatPrices[seatNum] = price;
                                    }
                                },
                                get baseTotal() {
                                    return Object.values(this.seatPrices).reduce((sum, val) => sum + val, 0);
                                },
                                get totalDiscount() {
                                    return this.selectedSeats.length > 0 ? this.discountPerSeat * this.selectedSeats.length : 0;
                                },
                                get gstAmount() {
                                    return Math.round((this.baseTotal - this.totalDiscount) * 0.05);
                                },
                                get grandTotal() {
                                    return Math.max(0, (this.baseTotal - this.totalDiscount) + this.gstAmount);
                                }
                             }"
                             class="bg-white rounded-3xl border border-slate-200/90 hover:border-red-400 hover:shadow-xl transition-all duration-200 overflow-hidden">
                            
                            <!-- Card Body -->
                            <div class="p-6">
                                
                                <!-- ROW 1: Operator Name & Starts At Price (No overlap) -->
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 pb-4 border-b border-slate-100">
                                    <!-- Left: Operator Brand -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-200 p-1 flex items-center justify-center shrink-0">
                                            <img src="{{ $operator->logo }}" alt="{{ $operator->name }}" class="w-full h-full object-cover rounded-xl">
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="font-extrabold text-base text-slate-900 leading-tight">{{ $operator->name }}</h4>
                                                <span class="inline-flex items-center gap-1 text-[11px] font-extrabold px-2 py-0.5 bg-emerald-600 text-white rounded-md">
                                                    <i data-lucide="star" class="w-3 h-3 fill-white text-white"></i> {{ number_format($operator->rating, 1) }}
                                                </span>
                                                <span class="text-[10px] font-extrabold px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md border border-blue-200">PRIMO</span>
                                            </div>
                                            <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $fleet->bus_type }} • ({{ $operator->total_reviews }} reviews)</p>
                                        </div>
                                    </div>

                                    <!-- Right: Price & Available Seats (Dedicated Right Block) -->
                                    <div class="text-left sm:text-right shrink-0">
                                        <span class="text-[10px] text-slate-400 uppercase font-extrabold block">Starts at</span>
                                        <div class="flex items-baseline sm:justify-end gap-2">
                                            <span class="text-xs text-slate-400 line-through">₹{{ number_format($schedule->sleeper_fare + 300, 0) }}</span>
                                            <span class="text-2xl font-extrabold text-slate-900">₹{{ number_format($schedule->sleeper_fare, 0) }}</span>
                                        </div>
                                        <span class="text-[11px] font-extrabold text-amber-600 block mt-0.5">
                                            {{ $schedule->available_seats_count }} Seats Available
                                        </span>
                                    </div>
                                </div>

                                <!-- ROW 2: Departure ──── Duration ──── Arrival (Full Width, Zero Collision) -->
                                <div class="py-5 flex items-center justify-between gap-4">
                                    <!-- Departure -->
                                    <div class="text-left min-w-0">
                                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900 block leading-tight">
                                            {{ date('h:i A', strtotime($schedule->departure_time)) }}
                                        </span>
                                        <h5 class="text-xs font-extrabold text-slate-800 mt-0.5">{{ $from }}</h5>
                                        <p class="text-[11px] text-slate-500 truncate max-w-[150px] sm:max-w-[200px]" title="{{ $schedule->boardingPoints->first()?->point_name }}">
                                            {{ $schedule->boardingPoints->first()?->point_name ?? 'Central Bus Terminal' }}
                                        </p>
                                    </div>

                                    <!-- Center Duration Line Graphic -->
                                    <div class="px-2 text-center shrink-0">
                                        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200 block mb-1">
                                            {{ $schedule->duration }}
                                        </span>
                                        <div class="w-20 sm:w-36 h-0.5 bg-slate-300 relative my-1.5 mx-auto">
                                            <div class="w-3 h-3 rounded-full bg-[#d84e55] absolute -top-[5px] left-1/2 -translate-x-1/2 border-2 border-white shadow-xs"></div>
                                        </div>
                                        <span class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider block">Express Direct</span>
                                    </div>

                                    <!-- Arrival -->
                                    <div class="text-right min-w-0">
                                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900 block leading-tight">
                                            {{ date('h:i A', strtotime($schedule->arrival_time)) }}
                                        </span>
                                        <h5 class="text-xs font-extrabold text-slate-800 mt-0.5">{{ $to }}</h5>
                                        <p class="text-[11px] text-slate-500 truncate max-w-[150px] sm:max-w-[200px]" title="{{ $schedule->droppingPoints->first()?->point_name }}">
                                            {{ $schedule->droppingPoints->first()?->point_name ?? 'Destination Hub' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- ROW 3: Amenities & VIEW SEATS Button -->
                                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 text-xs text-slate-600 flex-wrap">
                                        @if($fleet->amenities)
                                            @foreach(array_slice($fleet->amenities, 0, 4) as $am)
                                                <span class="flex items-center gap-1 font-medium bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-200">
                                                    <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i> {{ $am }}
                                                </span>
                                            @endforeach
                                        @endif
                                        <span class="text-[11px] font-semibold text-slate-400 hidden md:inline">• Free Cancellation up to 6 hrs</span>
                                    </div>

                                    <button type="button" @click="openSeats = !openSeats"
                                            class="w-full sm:w-auto px-6 py-2.5 bg-[#d84e55] hover:bg-[#c13b42] text-white font-extrabold text-xs rounded-xl shadow-md shadow-red-600/20 transition flex items-center justify-center gap-2 shrink-0">
                                        <i data-lucide="armchair" class="w-4 h-4"></i>
                                        <span x-text="openSeats ? 'HIDE SEATS' : 'VIEW SEATS'"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- ======================================================= -->
                            <!-- MOBILE APP-LIKE FULL-SCREEN SEAT SELECTION SHEET (lg:hidden) -->
                            <!-- ======================================================= -->
                            <div class="lg:hidden fixed inset-0 z-50 bg-white flex flex-col overflow-hidden"
                                 x-show="openSeats"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-full"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-full">
                                
                                <!-- Mobile App Top Bar -->
                                <div class="h-14 bg-[#d84e55] text-white px-4 flex items-center justify-between shrink-0 shadow-md">
                                    <button type="button" @click="if(step > 1) step--; else openSeats = false" class="p-1 -ml-1 text-white hover:bg-white/20 rounded-lg">
                                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                                    </button>
                                    <div class="text-center min-w-0">
                                        <h4 class="text-xs font-black truncate max-w-[200px]">{{ $operator->name }}</h4>
                                        <p class="text-[10px] text-white/80 font-semibold">{{ $from }} → {{ $to }} • {{ date('d M', strtotime($date)) }}</p>
                                    </div>
                                    <button type="button" @click="openSeats = false" class="p-1 text-white hover:bg-white/20 rounded-lg">
                                        <i data-lucide="x" class="w-5 h-5"></i>
                                    </button>
                                </div>

                                <!-- Mobile 3-Step Wizard Navigation -->
                                <div class="bg-white border-b border-slate-200 px-4 py-2.5 flex items-center justify-between text-xs font-bold shrink-0">
                                    <button type="button" @click="step = 1"
                                            :class="step === 1 ? 'text-[#d84e55] font-black border-b-2 border-[#d84e55] pb-1' : 'text-slate-400 font-semibold'">
                                        1. Select Seats
                                    </button>
                                    <button type="button" @click="if(selectedSeats.length > 0) step = 2; else alert('Please select at least 1 seat first.')"
                                            :class="step === 2 ? 'text-[#d84e55] font-black border-b-2 border-[#d84e55] pb-1' : 'text-slate-400 font-semibold'">
                                        2. Board/Drop
                                    </button>
                                    <button type="button" @click="if(selectedSeats.length > 0) step = 3; else alert('Please select seats first.')"
                                            :class="step === 3 ? 'text-[#d84e55] font-black border-b-2 border-[#d84e55] pb-1' : 'text-slate-400 font-semibold'">
                                        3. Passenger Info
                                    </button>
                                </div>

                                <!-- Scrollable Mobile Content Area -->
                                <div class="flex-1 overflow-y-auto p-4 pb-28 space-y-4">
                                    <!-- STEP 1: MOBILE SEAT SELECTION -->
                                    <div x-show="step === 1" class="space-y-4">
                                        <!-- Segmented Deck Selector -->
                                        <div class="flex items-center p-1 bg-slate-100 rounded-2xl max-w-xs mx-auto">
                                            <button type="button" @click="mobileDeck = 'lower'"
                                                    :class="mobileDeck === 'lower' ? 'bg-white text-[#d84e55] font-black shadow-xs' : 'text-slate-600 font-semibold'"
                                                    class="flex-1 py-2 text-xs rounded-xl transition text-center">
                                                Lower Deck ({{ $lowerLayout->flatten()->count() }})
                                            </button>
                                            <button type="button" @click="mobileDeck = 'upper'"
                                                    :class="mobileDeck === 'upper' ? 'bg-white text-[#d84e55] font-black shadow-xs' : 'text-slate-600 font-semibold'"
                                                    class="flex-1 py-2 text-xs rounded-xl transition text-center">
                                                Upper Deck ({{ $upperLayout->flatten()->count() }})
                                            </button>
                                        </div>

                                        <!-- Mobile Cabin Visualizer -->
                                        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-4 max-w-xs mx-auto">
                                            <!-- Steering wheel indicator on lower deck -->
                                            <div class="flex justify-end pb-3 text-slate-400">
                                                <div class="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center bg-white" title="Driver Cabin">
                                                    <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                        <path d="M12 2v7"></path>
                                                        <path d="M4.93 16.5l6.07-3.5"></path>
                                                        <path d="M19.07 16.5l-6.07-3.5"></path>
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Lower Deck Layout (Mobile) -->
                                            <div x-show="mobileDeck === 'lower'" class="space-y-3.5">
                                                @foreach($lowerLayout as $rowNum => $rowSeats)
                                                    @php
                                                        $seatLeft = $rowSeats->firstWhere('col_num', 1);
                                                        $seatR1 = $rowSeats->firstWhere('col_num', 3);
                                                        $seatR2 = $rowSeats->firstWhere('col_num', 4);
                                                    @endphp
                                                    <div class="flex items-center justify-between">
                                                        <!-- Left Berth -->
                                                        @if($seatLeft)
                                                            @php
                                                                $isBooked = in_array($seatLeft->seat_number, $bookedSeatsList);
                                                                $seatPrice = $baseFare + 50;
                                                            @endphp
                                                            <div class="flex flex-col items-center">
                                                                <button type="button"
                                                                        @click="toggleSeat('{{ $seatLeft->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                        class="w-12 h-20 rounded-xl flex flex-col justify-between items-center py-1.5 transition relative active:scale-95
                                                                               {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatLeft->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600' : 'border-2 border-emerald-600 bg-white text-emerald-800') }}"
                                                                        :class="selectedSeats.includes('{{ $seatLeft->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''">
                                                                    <div class="w-6 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                    @if($isBooked)
                                                                        <span class="text-[9px] font-black uppercase text-[#8C88A8]">Sold</span>
                                                                    @elseif($seatLeft->is_ladies_quota)
                                                                        <template x-if="!selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                            <svg class="w-4 h-4 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                <circle cx="12" cy="5" r="3"></circle>
                                                                                <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                            </svg>
                                                                        </template>
                                                                        <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                            <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                        </template>
                                                                    @else
                                                                        <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                            <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                        </template>
                                                                    @endif
                                                                    <span class="text-[9px] font-black opacity-80">{{ $seatLeft->seat_number }}</span>
                                                                </button>
                                                                <span class="text-[10px] font-bold mt-1 {{ $isBooked ? 'text-slate-300' : 'text-slate-800' }}">
                                                                    {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="w-12 h-20"></div>
                                                        @endif

                                                        <div class="w-6"></div> <!-- Walking Aisle -->

                                                        <!-- Double Right Berths -->
                                                        <div class="flex items-center gap-2">
                                                            @foreach([$seatR1, $seatR2] as $seatRight)
                                                                @if($seatRight)
                                                                    @php
                                                                        $isBooked = in_array($seatRight->seat_number, $bookedSeatsList);
                                                                        $seatPrice = $rowNum == 6 ? max(500, $baseFare - 100) : $baseFare;
                                                                    @endphp
                                                                    <div class="flex flex-col items-center">
                                                                        <button type="button"
                                                                                @click="toggleSeat('{{ $seatRight->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                                class="w-12 h-20 rounded-xl flex flex-col justify-between items-center py-1.5 transition relative active:scale-95
                                                                                       {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatRight->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600' : 'border-2 border-emerald-600 bg-white text-emerald-800') }}"
                                                                                :class="selectedSeats.includes('{{ $seatRight->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''">
                                                                            <div class="w-6 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                            @if($isBooked)
                                                                                <span class="text-[9px] font-black uppercase text-[#8C88A8]">Sold</span>
                                                                            @elseif($seatRight->is_ladies_quota)
                                                                                <template x-if="!selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                    <svg class="w-4 h-4 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                        <circle cx="12" cy="5" r="3"></circle>
                                                                                        <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                                    </svg>
                                                                                </template>
                                                                                <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @else
                                                                                <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @endif
                                                                            <span class="text-[9px] font-black opacity-80">{{ $seatRight->seat_number }}</span>
                                                                        </button>
                                                                        <span class="text-[10px] font-bold mt-1 {{ $isBooked ? 'text-slate-300' : 'text-slate-800' }}">
                                                                            {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Upper Deck Layout (Mobile) -->
                                            <div x-show="mobileDeck === 'upper'" class="space-y-3.5">
                                                @foreach($upperLayout as $rowNum => $rowSeats)
                                                    @php
                                                        $seatLeft = $rowSeats->firstWhere('col_num', 1);
                                                        $seatR1 = $rowSeats->firstWhere('col_num', 3);
                                                        $seatR2 = $rowSeats->firstWhere('col_num', 4);
                                                    @endphp
                                                    <div class="flex items-center justify-between">
                                                        <!-- Left Berth -->
                                                        @if($seatLeft)
                                                            @php
                                                                $isBooked = in_array($seatLeft->seat_number, $bookedSeatsList);
                                                                $seatPrice = $baseFare + 100;
                                                            @endphp
                                                            <div class="flex flex-col items-center">
                                                                <button type="button"
                                                                        @click="toggleSeat('{{ $seatLeft->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                        class="w-12 h-20 rounded-xl flex flex-col justify-between items-center py-1.5 transition relative active:scale-95
                                                                               {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatLeft->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600' : 'border-2 border-emerald-600 bg-white text-emerald-800') }}"
                                                                        :class="selectedSeats.includes('{{ $seatLeft->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''">
                                                                    <div class="w-6 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                    @if($isBooked)
                                                                        <span class="text-[9px] font-black uppercase text-[#8C88A8]">Sold</span>
                                                                    @elseif($seatLeft->is_ladies_quota)
                                                                        <template x-if="!selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                            <svg class="w-4 h-4 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                <circle cx="12" cy="5" r="3"></circle>
                                                                                <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                            </svg>
                                                                        </template>
                                                                        <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                            <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                        </template>
                                                                    @else
                                                                        <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                            <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                        </template>
                                                                    @endif
                                                                    <span class="text-[9px] font-black opacity-80">{{ $seatLeft->seat_number }}</span>
                                                                </button>
                                                                <span class="text-[10px] font-bold mt-1 {{ $isBooked ? 'text-slate-300' : 'text-slate-800' }}">
                                                                    {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="w-12 h-20"></div>
                                                        @endif

                                                        <div class="w-6"></div>

                                                        <!-- Double Right Berths -->
                                                        <div class="flex items-center gap-2">
                                                            @foreach([$seatR1, $seatR2] as $seatRight)
                                                                @if($seatRight)
                                                                    @php
                                                                        $isBooked = in_array($seatRight->seat_number, $bookedSeatsList);
                                                                        $seatPrice = $rowNum == 6 ? max(500, $baseFare - 100) : max(500, $baseFare - 50);
                                                                    @endphp
                                                                    <div class="flex flex-col items-center">
                                                                        <button type="button"
                                                                                @click="toggleSeat('{{ $seatRight->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                                class="w-12 h-20 rounded-xl flex flex-col justify-between items-center py-1.5 transition relative active:scale-95
                                                                                       {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatRight->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600' : 'border-2 border-emerald-600 bg-white text-emerald-800') }}"
                                                                                :class="selectedSeats.includes('{{ $seatRight->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''">
                                                                            <div class="w-6 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                            @if($isBooked)
                                                                                <span class="text-[9px] font-black uppercase text-[#8C88A8]">Sold</span>
                                                                            @elseif($seatRight->is_ladies_quota)
                                                                                <template x-if="!selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                    <svg class="w-4 h-4 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                        <circle cx="12" cy="5" r="3"></circle>
                                                                                        <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                                    </svg>
                                                                                </template>
                                                                                <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @else
                                                                                <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-4 h-4 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @endif
                                                                            <span class="text-[9px] font-black opacity-80">{{ $seatRight->seat_number }}</span>
                                                                        </button>
                                                                        <span class="text-[10px] font-bold mt-1 {{ $isBooked ? 'text-slate-300' : 'text-slate-800' }}">
                                                                            {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Legend on Mobile -->
                                        <div class="flex items-center justify-around text-[10px] font-extrabold text-slate-600 bg-white p-3 rounded-2xl border border-slate-200">
                                            <span class="flex items-center gap-1">
                                                <span class="w-3 h-4 rounded-xs border-2 border-emerald-600 bg-white inline-block"></span> Available
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="w-3 h-4 rounded-xs bg-emerald-600 inline-block"></span> Selected
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="w-3 h-4 rounded-xs bg-[#F1F0F7] border border-[#DDDCE5] inline-block"></span> Sold
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="w-3 h-4 rounded-xs border-2 border-pink-400 bg-pink-50 inline-block"></span> Ladies
                                            </span>
                                        </div>
                                    </div>

                                    <!-- STEP 2: MOBILE BOARDING / DROPPING POINTS -->
                                    <div x-show="step === 2" class="space-y-4">
                                        <!-- Segmented Points Tab -->
                                        <div class="flex items-center p-1 bg-slate-100 rounded-2xl">
                                            <button type="button" @click="mobilePointTab = 'boarding'"
                                                    :class="mobilePointTab === 'boarding' ? 'bg-white text-[#d84e55] font-black shadow-xs' : 'text-slate-600 font-semibold'"
                                                    class="flex-1 py-2 text-xs rounded-xl transition text-center">
                                                Boarding Point
                                            </button>
                                            <button type="button" @click="mobilePointTab = 'dropping'"
                                                    :class="mobilePointTab === 'dropping' ? 'bg-white text-[#d84e55] font-black shadow-xs' : 'text-slate-600 font-semibold'"
                                                    class="flex-1 py-2 text-xs rounded-xl transition text-center">
                                                Dropping Point
                                            </button>
                                        </div>

                                        <!-- Boarding List -->
                                        <div x-show="mobilePointTab === 'boarding'" class="space-y-2">
                                            @foreach($schedule->boardingPoints as $bp)
                                                <label class="flex items-start gap-3 p-3.5 rounded-2xl border transition cursor-pointer"
                                                       :class="boardingPoint === '{{ $bp->point_name }} ({{ $bp->point_time }})' ? 'border-[#d84e55] bg-red-50/50 shadow-xs' : 'border-slate-200 bg-white'">
                                                    <input type="radio" name="m_bp_{{ $schedule->id }}" value="{{ $bp->point_name }} ({{ $bp->point_time }})" x-model="boardingPoint" class="mt-1 text-[#d84e55]">
                                                    <div class="text-xs">
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-black text-[#d84e55]">{{ $bp->point_time }}</span>
                                                            <strong class="text-slate-900">{{ $bp->point_name }}</strong>
                                                        </div>
                                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $bp->landmark }}</p>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>

                                        <!-- Dropping List -->
                                        <div x-show="mobilePointTab === 'dropping'" class="space-y-2">
                                            @foreach($schedule->droppingPoints as $dp)
                                                <label class="flex items-start gap-3 p-3.5 rounded-2xl border transition cursor-pointer"
                                                       :class="droppingPoint === '{{ $dp->point_name }} ({{ $dp->point_time }})' ? 'border-[#d84e55] bg-red-50/50 shadow-xs' : 'border-slate-200 bg-white'">
                                                    <input type="radio" name="m_dp_{{ $schedule->id }}" value="{{ $dp->point_name }} ({{ $dp->point_time }})" x-model="droppingPoint" class="mt-1 text-[#d84e55]">
                                                    <div class="text-xs">
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-black text-[#d84e55]">{{ $dp->point_time }}</span>
                                                            <strong class="text-slate-900">{{ $dp->point_name }}</strong>
                                                        </div>
                                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $dp->landmark }}</p>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- STEP 3: MOBILE PASSENGER FORM -->
                                    <div x-show="step === 3" class="space-y-4">
                                        <form id="mobile-booking-form-{{ $schedule->id }}" action="{{ route('buses.book') }}" method="POST" class="space-y-3.5">
                                            @csrf
                                            <input type="hidden" name="bus_schedule_id" value="{{ $schedule->id }}">
                                            <input type="hidden" name="travel_date" value="{{ $date }}">
                                            <input type="hidden" name="seats" :value="selectedSeats.join(',')">
                                            <input type="hidden" name="boarding_point" :value="boardingPoint">
                                            <input type="hidden" name="dropping_point" :value="droppingPoint">

                                            <!-- Primary Passenger -->
                                            <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3">
                                                <h5 class="text-xs font-black text-slate-900 uppercase">Primary Passenger</h5>
                                                <div>
                                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Full Name *</label>
                                                    <input type="text" name="passenger_name" required placeholder="e.g. Rahul Sharma" autocomplete="name"
                                                           value="{{ Auth::user()?->name ?? '' }}"
                                                           class="w-full text-xs font-bold p-3 border border-slate-300 rounded-xl focus:border-[#d84e55]">
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Age *</label>
                                                        <input type="number" name="passenger_age" required placeholder="Age" min="1" max="110" value="28"
                                                               class="w-full text-xs font-bold p-3 border border-slate-300 rounded-xl focus:border-[#d84e55]">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Gender *</label>
                                                        <select name="passenger_gender" required class="w-full text-xs font-bold p-3 border border-slate-300 rounded-xl focus:border-[#d84e55] bg-white">
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Mobile Phone *</label>
                                                    <input type="tel" name="contact_phone" required placeholder="+91 98100 12345" autocomplete="tel"
                                                           value="{{ Auth::user()?->phone ?? '+91 98100 12345' }}"
                                                           class="w-full text-xs font-bold p-3 border border-slate-300 rounded-xl focus:border-[#d84e55]">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase mb-1">Email *</label>
                                                    <input type="email" name="contact_email" required placeholder="name@domain.com" autocomplete="email"
                                                           value="{{ Auth::user()?->email ?? 'rahul.sharma@gmail.com' }}"
                                                           class="w-full text-xs font-bold p-3 border border-slate-300 rounded-xl focus:border-[#d84e55]">
                                                </div>
                                            </div>

                                            <!-- Fare Breakdown Card -->
                                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs space-y-1.5">
                                                <div class="flex justify-between text-slate-600">
                                                    <span>Selected Berths:</span>
                                                    <strong class="text-slate-900" x-text="selectedSeats.join(', ')"></strong>
                                                </div>
                                                <div class="flex justify-between text-slate-600">
                                                    <span>Base Fare:</span>
                                                    <span>₹<span x-text="baseTotal"></span></span>
                                                </div>
                                                <div class="flex justify-between text-emerald-600 font-bold" x-show="selectedSeats.length > 0">
                                                    <span>Discount:</span>
                                                    <span>- ₹<span x-text="totalDiscount"></span></span>
                                                </div>
                                                <div class="flex justify-between text-slate-600">
                                                    <span>GST (5%):</span>
                                                    <span>+ ₹<span x-text="gstAmount"></span></span>
                                                </div>
                                                <div class="flex justify-between text-sm font-black text-slate-900 pt-2 border-t border-slate-200">
                                                    <span>Total Payable:</span>
                                                    <span class="text-[#d84e55] text-base font-black">₹<span x-text="grandTotal"></span></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Persistent Pinned Mobile Bottom Bar -->
                                <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 px-4 py-3 shadow-2xl flex items-center justify-between z-50">
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase text-slate-400 block leading-tight">Total Fare (<span x-text="selectedSeats.length"></span>)</span>
                                        <span class="text-lg font-black text-[#d84e55]">₹<span x-text="grandTotal"></span></span>
                                    </div>

                                    <template x-if="step === 1">
                                        <button type="button"
                                                @click="if(selectedSeats.length > 0) step = 2; else alert('Please tap any green berth on the bus layout to select your seat.')"
                                                class="px-6 py-3 bg-[#d84e55] text-white font-black text-xs rounded-xl shadow-md transition flex items-center gap-1.5">
                                            <span>Continue</span>
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </button>
                                    </template>

                                    <template x-if="step === 2">
                                        <button type="button" @click="step = 3"
                                                class="px-6 py-3 bg-[#d84e55] text-white font-black text-xs rounded-xl shadow-md transition flex items-center gap-1.5">
                                            <span>Continue</span>
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </button>
                                    </template>

                                    <template x-if="step === 3">
                                        <button type="button"
                                                @click="document.getElementById('mobile-booking-form-' + {{ $schedule->id }}).submit()"
                                                class="px-6 py-3 bg-[#d84e55] text-white font-black text-xs rounded-xl shadow-md transition flex items-center gap-1.5">
                                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                                            <span>PAY & BOOK NOW</span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- 1:1 REDBUS REPLICA SEAT & POLICY DRAWER (DESKTOP lg:block) -->
                            <div x-show="openSeats" x-transition.duration.300ms class="hidden lg:block border-t border-slate-200 bg-[#f8f9fa] p-4 sm:p-6">
                                
                                <!-- TOP STEP WIZARD BAR (Exact redBus Header) -->
                                <div class="bg-white rounded-2xl border border-slate-200 px-4 py-3 mb-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
                                    <!-- Left: Route Info -->
                                    <div class="flex items-center gap-2 text-xs font-extrabold text-slate-800">
                                        <button type="button" @click="openSeats = false" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                        <span>{{ $from }}</span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>{{ $to }}</span>
                                        <span class="text-slate-400 font-normal">({{ date('D d M', strtotime($date)) }})</span>
                                    </div>

                                    <!-- Center: 3-Step Wizard Navigation Tabs -->
                                    <div class="flex items-center gap-6 sm:gap-8 text-xs font-bold">
                                        <button type="button" @click="step = 1"
                                                :class="step === 1 ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                            Select seats
                                        </button>
                                        <button type="button" @click="if(selectedSeats.length > 0) step = 2; else alert('Please select seats on the bus layout first.')"
                                                :class="step === 2 ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                            Board/Drop point
                                        </button>
                                        <button type="button" @click="if(selectedSeats.length > 0) step = 3; else alert('Please select seats on the bus layout first.')"
                                                :class="step === 3 ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                            Passenger Info
                                        </button>
                                    </div>

                                    <!-- Right: Return Trip Offer Badge -->
                                    <div class="flex items-center gap-1.5 bg-amber-100/90 text-amber-900 border border-amber-300 px-3 py-1 rounded-lg text-[11px] font-extrabold">
                                        <i data-lucide="ticket-percent" class="w-3.5 h-3.5 text-amber-700"></i>
                                        <span>Return trip 10% OFF</span>
                                    </div>
                                </div>

                                <!-- MAIN SPLIT VIEW: SIDE-BY-SIDE CABIN (LEFT) & DETAILS/CHECKOUT (RIGHT) -->
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                                    
                                    <!-- ==================== LEFT COLUMN: DUAL-DECK CABIN VISUALIZER ==================== -->
                                    <div class="lg:col-span-6 xl:col-span-5 bg-white rounded-3xl p-5 border border-slate-200 shadow-sm">
                                        
                                        @php
                                            $bookedSeatsList = \App\Models\BusSeatBooking::where('bus_schedule_id', $schedule->id)
                                                ->whereDate('travel_date', $date)
                                                ->where('status', 'confirmed')
                                                ->pluck('seat_number')
                                                ->toArray();
                                            
                                            $baseFare = (int) $schedule->sleeper_fare;
                                            $lowerLayout = $fleet->seatLayouts->where('deck', 'lower')->groupBy('row_num');
                                            $upperLayout = $fleet->seatLayouts->where('deck', 'upper')->groupBy('row_num');
                                        @endphp

                                        <!-- Side-by-Side Dual Deck Layout Box -->
                                        <div class="overflow-x-auto pb-2">
                                            <div class="min-w-[360px] flex items-start justify-center gap-5 sm:gap-6">
                                                
                                                <!-- LOWER DECK COLUMN -->
                                                <div class="flex-1 max-w-[175px]">
                                                    <!-- Deck Header with Steering Wheel -->
                                                    <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-200">
                                                        <span class="text-xs font-black text-slate-800">Lower deck</span>
                                                        <div class="w-7 h-7 rounded-full border border-slate-300 flex items-center justify-center bg-slate-50" title="Driver Cabin">
                                                            <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                                <path d="M12 2v7"></path>
                                                                <path d="M4.93 16.5l6.07-3.5"></path>
                                                                <path d="M19.07 16.5l-6.07-3.5"></path>
                                                            </svg>
                                                        </div>
                                                    </div>

                                                    <!-- Lower Deck Berth Rows -->
                                                    <div class="space-y-3.5">
                                                        @foreach($lowerLayout as $rowNum => $rowSeats)
                                                            @php
                                                                $seatLeft = $rowSeats->firstWhere('col_num', 1);
                                                                $seatR1 = $rowSeats->firstWhere('col_num', 3);
                                                                $seatR2 = $rowSeats->firstWhere('col_num', 4);
                                                            @endphp
                                                            <div class="flex items-center justify-between gap-1.5">
                                                                <!-- Single Left Berth -->
                                                                @if($seatLeft)
                                                                    @php
                                                                        $isBooked = in_array($seatLeft->seat_number, $bookedSeatsList);
                                                                        $seatPrice = $baseFare + 50;
                                                                    @endphp
                                                                    <div class="flex flex-col items-center">
                                                                        <button type="button"
                                                                                @click="toggleSeat('{{ $seatLeft->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                                class="w-9 sm:w-10 h-16 sm:h-18 rounded-md flex flex-col justify-between items-center py-1 transition relative
                                                                                       {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatLeft->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600 hover:bg-pink-100 cursor-pointer' : 'border-2 border-emerald-600 bg-white hover:bg-emerald-50 text-emerald-800 cursor-pointer') }}"
                                                                                :class="selectedSeats.includes('{{ $seatLeft->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''"
                                                                                title="{{ $seatLeft->seat_number }} - ₹{{ $seatPrice }}">
                                                                            <!-- Berth Pillow Pill Contour -->
                                                                            <div class="w-5 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                            
                                                                            @if($isBooked)
                                                                                <span class="text-[8px] font-black uppercase tracking-wider text-[#8C88A8]">Sold</span>
                                                                            @elseif($seatLeft->is_ladies_quota)
                                                                                <template x-if="!selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                                    <svg class="w-3.5 h-3.5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                        <circle cx="12" cy="5" r="3"></circle>
                                                                                        <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                                    </svg>
                                                                                </template>
                                                                                <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @else
                                                                                <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @endif
                                                                            <span class="text-[8px] font-extrabold opacity-80">{{ $seatLeft->seat_number }}</span>
                                                                        </button>
                                                                        <span class="text-[9px] font-bold mt-0.5 {{ $isBooked ? 'text-slate-300' : 'text-slate-700' }}">
                                                                            {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="w-9 sm:w-10 h-16 sm:h-18"></div>
                                                                @endif

                                                                <!-- Walking Aisle -->
                                                                <div class="w-3 sm:w-4"></div>

                                                                <!-- Double Right Berths -->
                                                                <div class="flex items-center gap-1.5">
                                                                    @foreach([$seatR1, $seatR2] as $seatRight)
                                                                        @if($seatRight)
                                                                            @php
                                                                                $isBooked = in_array($seatRight->seat_number, $bookedSeatsList);
                                                                                $seatPrice = $rowNum == 6 ? max(500, $baseFare - 100) : $baseFare;
                                                                            @endphp
                                                                            <div class="flex flex-col items-center">
                                                                                <button type="button"
                                                                                        @click="toggleSeat('{{ $seatRight->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                                        class="w-9 sm:w-10 h-16 sm:h-18 rounded-md flex flex-col justify-between items-center py-1 transition relative
                                                                                               {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatRight->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600 hover:bg-pink-100 cursor-pointer' : 'border-2 border-emerald-600 bg-white hover:bg-emerald-50 text-emerald-800 cursor-pointer') }}"
                                                                                        :class="selectedSeats.includes('{{ $seatRight->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''"
                                                                                        title="{{ $seatRight->seat_number }} - ₹{{ $seatPrice }}">
                                                                                    <div class="w-5 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                                    @if($isBooked)
                                                                                        <span class="text-[8px] font-black uppercase tracking-wider text-[#8C88A8]">Sold</span>
                                                                                    @elseif($seatRight->is_ladies_quota)
                                                                                        <template x-if="!selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                            <svg class="w-3.5 h-3.5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                                <circle cx="12" cy="5" r="3"></circle>
                                                                                                <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                                            </svg>
                                                                                        </template>
                                                                                        <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                        </template>
                                                                                    @else
                                                                                        <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                        </template>
                                                                                    @endif
                                                                                    <span class="text-[8px] font-extrabold opacity-80">{{ $seatRight->seat_number }}</span>
                                                                                </button>
                                                                                <span class="text-[9px] font-bold mt-0.5 {{ $isBooked ? 'text-slate-300' : 'text-slate-700' }}">
                                                                                    {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <!-- Vertical Divider Between Decks -->
                                                <div class="w-px bg-slate-200 self-stretch my-1"></div>

                                                <!-- UPPER DECK COLUMN (Side-by-Side with Lower Deck) -->
                                                <div class="flex-1 max-w-[175px]">
                                                    <!-- Deck Header -->
                                                    <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-200">
                                                        <span class="text-xs font-black text-slate-800">Upper deck</span>
                                                        <div class="w-7 h-7"></div> <!-- Spacer matching steering wheel -->
                                                    </div>

                                                    <!-- Upper Deck Berth Rows -->
                                                    <div class="space-y-3.5">
                                                        @foreach($upperLayout as $rowNum => $rowSeats)
                                                            @php
                                                                $seatLeft = $rowSeats->firstWhere('col_num', 1);
                                                                $seatR1 = $rowSeats->firstWhere('col_num', 3);
                                                                $seatR2 = $rowSeats->firstWhere('col_num', 4);
                                                            @endphp
                                                            <div class="flex items-center justify-between gap-1.5">
                                                                <!-- Single Left Berth -->
                                                                @if($seatLeft)
                                                                    @php
                                                                        $isBooked = in_array($seatLeft->seat_number, $bookedSeatsList);
                                                                        $seatPrice = $baseFare + 100;
                                                                    @endphp
                                                                    <div class="flex flex-col items-center">
                                                                        <button type="button"
                                                                                @click="toggleSeat('{{ $seatLeft->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                                class="w-9 sm:w-10 h-16 sm:h-18 rounded-md flex flex-col justify-between items-center py-1 transition relative
                                                                                       {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatLeft->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600 hover:bg-pink-100 cursor-pointer' : 'border-2 border-emerald-600 bg-white hover:bg-emerald-50 text-emerald-800 cursor-pointer') }}"
                                                                                :class="selectedSeats.includes('{{ $seatLeft->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''"
                                                                                title="{{ $seatLeft->seat_number }} - ₹{{ $seatPrice }}">
                                                                            <div class="w-5 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                            @if($isBooked)
                                                                                <span class="text-[8px] font-black uppercase tracking-wider text-[#8C88A8]">Sold</span>
                                                                            @elseif($seatLeft->is_ladies_quota)
                                                                                <template x-if="!selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                                    <svg class="w-3.5 h-3.5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                        <circle cx="12" cy="5" r="3"></circle>
                                                                                        <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                                    </svg>
                                                                                </template>
                                                                                <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @else
                                                                                <template x-if="selectedSeats.includes('{{ $seatLeft->seat_number }}')">
                                                                                    <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                </template>
                                                                            @endif
                                                                            <span class="text-[8px] font-extrabold opacity-80">{{ $seatLeft->seat_number }}</span>
                                                                        </button>
                                                                        <span class="text-[9px] font-bold mt-0.5 {{ $isBooked ? 'text-slate-300' : 'text-slate-700' }}">
                                                                            {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="w-9 sm:w-10 h-16 sm:h-18"></div>
                                                                @endif

                                                                <!-- Walking Aisle -->
                                                                <div class="w-3 sm:w-4"></div>

                                                                <!-- Double Right Berths -->
                                                                <div class="flex items-center gap-1.5">
                                                                    @foreach([$seatR1, $seatR2] as $seatRight)
                                                                        @if($seatRight)
                                                                            @php
                                                                                $isBooked = in_array($seatRight->seat_number, $bookedSeatsList);
                                                                                $seatPrice = $rowNum == 6 ? max(500, $baseFare - 100) : max(500, $baseFare - 50);
                                                                            @endphp
                                                                            <div class="flex flex-col items-center">
                                                                                <button type="button"
                                                                                        @click="toggleSeat('{{ $seatRight->seat_number }}', {{ $seatPrice }}, {{ $isBooked ? 'true' : 'false' }})"
                                                                                        class="w-9 sm:w-10 h-16 sm:h-18 rounded-md flex flex-col justify-between items-center py-1 transition relative
                                                                                               {{ $isBooked ? 'bg-[#F1F0F7] border border-[#DDDCE5] cursor-not-allowed' : ($seatRight->is_ladies_quota ? 'border-2 border-pink-400 bg-pink-50/30 text-pink-600 hover:bg-pink-100 cursor-pointer' : 'border-2 border-emerald-600 bg-white hover:bg-emerald-50 text-emerald-800 cursor-pointer') }}"
                                                                                        :class="selectedSeats.includes('{{ $seatRight->seat_number }}') ? '!bg-emerald-600 !border-emerald-600 !text-white' : ''"
                                                                                        title="{{ $seatRight->seat_number }} - ₹{{ $seatPrice }}">
                                                                                    <div class="w-5 h-1.5 rounded-xs border border-current opacity-60"></div>
                                                                                    @if($isBooked)
                                                                                        <span class="text-[8px] font-black uppercase tracking-wider text-[#8C88A8]">Sold</span>
                                                                                    @elseif($seatRight->is_ladies_quota)
                                                                                        <template x-if="!selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                            <svg class="w-3.5 h-3.5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                                                                                <circle cx="12" cy="5" r="3"></circle>
                                                                                                <path d="M9 10h6l1.5 8h-2l-1-4h-3l-1 4h-2L9 10z"></path>
                                                                                            </svg>
                                                                                        </template>
                                                                                        <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                        </template>
                                                                                    @else
                                                                                        <template x-if="selectedSeats.includes('{{ $seatRight->seat_number }}')">
                                                                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white stroke-[3]"></i>
                                                                                        </template>
                                                                                    @endif
                                                                                    <span class="text-[8px] font-extrabold opacity-80">{{ $seatRight->seat_number }}</span>
                                                                                </button>
                                                                                <span class="text-[9px] font-bold mt-0.5 {{ $isBooked ? 'text-slate-300' : 'text-slate-700' }}">
                                                                                    {{ $isBooked ? 'Sold' : '₹'.$seatPrice }}
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Seat Legend (Under Decks) -->
                                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-around text-[10px] font-bold text-slate-600 flex-wrap gap-2">
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-3 h-4 rounded-xs border-2 border-emerald-600 bg-white inline-block"></span> Available
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-3 h-4 rounded-xs bg-emerald-600 inline-block"></span> Selected
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-3 h-4 rounded-xs bg-[#F1F0F7] border border-[#DDDCE5] inline-block"></span> Sold
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-3 h-4 rounded-xs border-2 border-pink-400 bg-pink-50 inline-block"></span> Ladies
                                            </span>
                                        </div>
                                    </div>

                                    <!-- ==================== RIGHT COLUMN: redBus OPERATOR INTELLIGENCE & POLICIES ==================== -->
                                    <div class="lg:col-span-6 xl:col-span-7 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between min-h-[460px]">
                                        
                                        <!-- STEP 1: OPERATOR DETAILS & HIGHLIGHTS / POLICIES (Matches Image 2 exactly) -->
                                        <div x-show="step === 1" class="space-y-4">
                                            <!-- Operator Header & RedBus Emerald Rating Badge -->
                                            <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
                                                <div>
                                                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900 leading-tight">{{ $operator->name }}</h3>
                                                    <p class="text-xs text-slate-500 font-semibold mt-0.5">
                                                        {{ date('H:i', strtotime($schedule->departure_time)) }} - {{ date('H:i', strtotime($schedule->arrival_time)) }} • {{ date('D d M', strtotime($date)) }}
                                                    </p>
                                                    <span class="text-xs font-bold text-slate-600 block mt-0.5">{{ $fleet->bus_type }}</span>
                                                </div>

                                                <!-- Emerald Star Rating Pill (Exact redBus badge from Image 2) -->
                                                <div class="px-2.5 py-1 bg-emerald-700 text-white rounded-lg text-center shrink-0 shadow-xs">
                                                    <div class="flex items-center justify-center gap-1 text-xs font-black">
                                                        <i data-lucide="star" class="w-3 h-3 fill-white text-white"></i>
                                                        <span>{{ number_format($operator->rating, 1) }}</span>
                                                    </div>
                                                    <span class="block text-[9px] font-bold text-emerald-100 leading-none mt-0.5">{{ $operator->total_reviews }}</span>
                                                </div>
                                            </div>

                                            <!-- Navigation Sub-Tabs (Highlights, Cancellation, Reschedule, Route, Boarding) -->
                                            <div class="flex items-center gap-4 sm:gap-6 border-b border-slate-100 pb-2 text-xs font-bold overflow-x-auto">
                                                <button type="button" @click="rightTab = 'highlights'"
                                                        :class="rightTab === 'highlights' ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                                    Highlights
                                                </button>
                                                <button type="button" @click="rightTab = 'cancellation'"
                                                        :class="rightTab === 'cancellation' ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                                    Cancellation policy
                                                </button>
                                                <button type="button" @click="rightTab = 'reschedule'"
                                                        :class="rightTab === 'reschedule' ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                                    Reschedule Policy
                                                </button>
                                                <button type="button" @click="rightTab = 'route'"
                                                        :class="rightTab === 'route' ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                                    Bus route
                                                </button>
                                                <button type="button" @click="rightTab = 'boarding'"
                                                        :class="rightTab === 'boarding' ? 'text-[#d84e55] font-extrabold border-b-2 border-[#d84e55] pb-1' : 'text-slate-500 hover:text-slate-800 pb-1'">
                                                    Boarding points
                                                </button>
                                            </div>

                                            <!-- TAB 1: HIGHLIGHTS VIEW (Image 2 exact match) -->
                                            <div x-show="rightTab === 'highlights'" class="space-y-3.5">
                                                <!-- Side-by-Side Punctuality & Women's Choice Chips -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3 flex items-center justify-between">
                                                        <div>
                                                            <span class="block text-xs font-black text-slate-900">94% on time</span>
                                                            <span class="block text-[11px] text-slate-500 font-medium">Based on live tracking</span>
                                                        </div>
                                                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                                                    </div>
                                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3">
                                                        <span class="block text-xs font-black text-slate-900">Women's choice</span>
                                                        <span class="block text-[11px] text-slate-500 font-medium">Highly rated by women</span>
                                                    </div>
                                                </div>

                                                <!-- Return Trip Offer Card -->
                                                <div class="bg-amber-50/80 border border-amber-200 rounded-2xl p-3 flex items-center gap-3">
                                                    <span class="bg-amber-100 text-amber-900 text-[10px] font-black px-2.5 py-1 rounded-md border border-amber-300">Return trip 10% OFF</span>
                                                    <span class="text-xs font-bold text-slate-700">Save more on your way back</span>
                                                </div>

                                                <!-- Cancellation Policy Table (Exact redBus format) -->
                                                <div>
                                                    <h4 class="text-xs font-black text-slate-900 mb-2">Cancellation policy</h4>
                                                    <div class="border border-slate-200 rounded-2xl overflow-hidden text-xs">
                                                        <div class="grid grid-cols-3 bg-slate-50 p-2.5 font-extrabold text-slate-700 text-[11px] border-b border-slate-200">
                                                            <div>Time before travel</div>
                                                            <div>Without free cancellation</div>
                                                            <div>With free cancellation</div>
                                                        </div>
                                                        <div class="grid grid-cols-3 p-2.5 text-slate-600 border-b border-slate-100">
                                                            <div class="font-semibold text-slate-800">Before 12 hrs of travel</div>
                                                            <div class="text-slate-700 font-medium">10% cancellation fee</div>
                                                            <div class="text-emerald-700 font-black">0% fee (100% Refund)</div>
                                                        </div>
                                                        <div class="grid grid-cols-3 p-2.5 text-slate-600 border-b border-slate-100 bg-slate-50/40">
                                                            <div class="font-semibold text-slate-800">Between 6 to 12 hrs</div>
                                                            <div class="text-slate-700 font-medium">25% cancellation fee</div>
                                                            <div class="text-emerald-700 font-black">0% fee (100% Refund)</div>
                                                        </div>
                                                        <div class="grid grid-cols-3 p-2.5 text-slate-600">
                                                            <div class="font-semibold text-slate-800">Within 6 hrs of travel</div>
                                                            <div class="text-rose-700 font-semibold">100% fee (No Refund)</div>
                                                            <div class="text-rose-700 font-semibold">100% fee</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- TAB 2: CANCELLATION DETAILS -->
                                            <div x-show="rightTab === 'cancellation'" class="space-y-3 text-xs text-slate-600">
                                                <p class="font-medium">Free cancellation is applicable on tickets cancelled 6 hours before journey time. Instant refunds are credited to original payment source within 15 minutes.</p>
                                                <div class="bg-blue-50 border border-blue-200 p-3 rounded-2xl text-blue-900 font-semibold">
                                                    💡 Pro Tip: Opt for Free Cancellation protection at checkout for zero penalty refunds.
                                                </div>
                                            </div>

                                            <!-- TAB 3: RESCHEDULE POLICY -->
                                            <div x-show="rightTab === 'reschedule'" class="space-y-3 text-xs text-slate-600">
                                                <p class="font-medium">Tickets booked on {{ $operator->name }} can be rescheduled up to 4 hours prior to scheduled departure time.</p>
                                                <ul class="list-disc pl-5 space-y-1 font-semibold text-slate-700">
                                                    <li>One free reschedule allowed per PNR</li>
                                                    <li>Difference in fare applies for higher category buses</li>
                                                </ul>
                                            </div>

                                            <!-- TAB 4: BUS ROUTE -->
                                            <div x-show="rightTab === 'route'" class="space-y-3 text-xs text-slate-700">
                                                <div class="flex items-center gap-3">
                                                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                                    <div>
                                                        <strong class="block text-slate-900">{{ $from }}</strong>
                                                        <span class="text-slate-500 text-[11px]">{{ $schedule->boardingPoints->first()?->point_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="w-0.5 h-6 bg-slate-200 ml-1.5 my-1"></div>
                                                <div class="flex items-center gap-3">
                                                    <span class="w-3 h-3 rounded-full bg-[#d84e55]"></span>
                                                    <div>
                                                        <strong class="block text-slate-900">{{ $to }}</strong>
                                                        <span class="text-slate-500 text-[11px]">{{ $schedule->droppingPoints->first()?->point_name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- TAB 5: BOARDING POINTS -->
                                            <div x-show="rightTab === 'boarding'" class="space-y-2 text-xs">
                                                @foreach($schedule->boardingPoints as $bp)
                                                    <div class="p-2.5 rounded-xl border border-slate-200 flex items-center justify-between">
                                                        <div>
                                                            <strong class="text-slate-900">{{ $bp->point_name }}</strong>
                                                            <span class="block text-[11px] text-slate-500">{{ $bp->landmark }}</span>
                                                        </div>
                                                        <span class="font-black text-[#d84e55]">{{ $bp->point_time }}</span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Sticky Bottom Action Bar for Step 1 -->
                                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                                                <div>
                                                    <span class="text-[10px] font-extrabold uppercase text-slate-400 block">Selected Berths</span>
                                                    <span class="text-sm font-extrabold text-slate-900" x-text="selectedSeats.length > 0 ? selectedSeats.join(', ') : 'None'"></span>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-[10px] font-extrabold uppercase text-slate-400 block">Total Fare</span>
                                                    <span class="text-xl font-black text-[#d84e55]">₹<span x-text="grandTotal"></span></span>
                                                </div>
                                                <button type="button" @click="if(selectedSeats.length > 0) step = 2; else alert('Please click on any green berth on the left to select your seat.')"
                                                        class="px-5 py-2.5 bg-[#d84e55] hover:bg-[#c13b42] text-white font-extrabold text-xs rounded-xl shadow-md shadow-red-600/20 transition flex items-center gap-1.5 shrink-0">
                                                    <span>Continue</span>
                                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- STEP 2: BOARDING & DROPPING POINTS SELECTION -->
                                        <div x-show="step === 2" class="space-y-4">
                                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                                <button type="button" @click="step = 1" class="text-xs font-bold text-slate-500 hover:text-slate-900 flex items-center gap-1">
                                                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back to Seats
                                                </button>
                                                <span class="text-xs font-black text-[#d84e55]">Step 2 of 3</span>
                                            </div>

                                            <!-- Boarding Point Selector -->
                                            <div>
                                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-600"></i> Select Boarding Point
                                                </h4>
                                                <div class="space-y-2 max-h-44 overflow-y-auto pr-1">
                                                    @foreach($schedule->boardingPoints as $bp)
                                                        <label class="flex items-start gap-3 p-3 rounded-2xl border transition cursor-pointer"
                                                               :class="boardingPoint === '{{ $bp->point_name }} ({{ $bp->point_time }})' ? 'border-[#d84e55] bg-red-50/50' : 'border-slate-200 hover:bg-slate-50'">
                                                            <input type="radio" name="temp_bp" value="{{ $bp->point_name }} ({{ $bp->point_time }})" x-model="boardingPoint" class="mt-1 text-[#d84e55]">
                                                            <div class="text-xs">
                                                                <div class="flex items-center gap-2">
                                                                    <span class="font-extrabold text-[#d84e55]">{{ $bp->point_time }}</span>
                                                                    <strong class="text-slate-900">{{ $bp->point_name }}</strong>
                                                                </div>
                                                                <p class="text-[11px] text-slate-500 mt-0.5">{{ $bp->landmark }}</p>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Dropping Point Selector -->
                                            <div class="pt-3 border-t border-slate-100">
                                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-600"></i> Select Dropping Point
                                                </h4>
                                                <div class="space-y-2 max-h-44 overflow-y-auto pr-1">
                                                    @foreach($schedule->droppingPoints as $dp)
                                                        <label class="flex items-start gap-3 p-3 rounded-2xl border transition cursor-pointer"
                                                               :class="droppingPoint === '{{ $dp->point_name }} ({{ $dp->point_time }})' ? 'border-[#d84e55] bg-red-50/50' : 'border-slate-200 hover:bg-slate-50'">
                                                            <input type="radio" name="temp_dp" value="{{ $dp->point_name }} ({{ $dp->point_time }})" x-model="droppingPoint" class="mt-1 text-[#d84e55]">
                                                            <div class="text-xs">
                                                                <div class="flex items-center gap-2">
                                                                    <span class="font-extrabold text-[#d84e55]">{{ $dp->point_time }}</span>
                                                                    <strong class="text-slate-900">{{ $dp->point_name }}</strong>
                                                                </div>
                                                                <p class="text-[11px] text-slate-500 mt-0.5">{{ $dp->landmark }}</p>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Bottom Step 2 CTA -->
                                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                                                <button type="button" @click="step = 1" class="text-xs font-bold text-slate-600">
                                                    Change Seats
                                                </button>
                                                <button type="button" @click="step = 3"
                                                        class="px-6 py-2.5 bg-[#d84e55] hover:bg-[#c13b42] text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-1.5">
                                                    <span>Continue to Passenger Info</span>
                                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- STEP 3: PASSENGER INFORMATION & CHECKOUT FORM -->
                                        <div x-show="step === 3" class="space-y-4">
                                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                                <button type="button" @click="step = 2" class="text-xs font-bold text-slate-500 hover:text-slate-900 flex items-center gap-1">
                                                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back to Points
                                                </button>
                                                <span class="text-xs font-black text-[#d84e55]">Step 3 of 3</span>
                                            </div>

                                            <form action="{{ route('buses.book') }}" method="POST" class="space-y-3.5">
                                                @csrf
                                                <input type="hidden" name="bus_schedule_id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="travel_date" value="{{ $date }}">
                                                <input type="hidden" name="seats" :value="selectedSeats.join(',')">
                                                <input type="hidden" name="boarding_point" :value="boardingPoint">
                                                <input type="hidden" name="dropping_point" :value="droppingPoint">

                                                <!-- Selected Summary Chip -->
                                                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 text-xs flex items-center justify-between">
                                                    <div>
                                                        <span class="text-[10px] font-extrabold text-slate-400 uppercase block">Selected Berths</span>
                                                        <span class="font-black text-slate-900" x-text="selectedSeats.join(', ')"></span>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="text-[10px] font-extrabold text-slate-400 uppercase block">Pick & Drop</span>
                                                        <span class="text-[11px] font-bold text-slate-700 truncate max-w-[150px] block" x-text="boardingPoint.split('(')[0]"></span>
                                                    </div>
                                                </div>

                                                <!-- Primary Passenger Fields -->
                                                <div>
                                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Primary Passenger Name *</label>
                                                    <input type="text" name="passenger_name" required placeholder="e.g. Rahul Sharma"
                                                           value="{{ Auth::user()?->name ?? '' }}"
                                                           class="w-full text-xs font-semibold px-3 py-2.5 border border-slate-300 rounded-xl focus:border-[#d84e55] focus:outline-hidden">
                                                </div>

                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Age *</label>
                                                        <input type="number" name="passenger_age" required placeholder="Age" min="1" max="110" value="28"
                                                               class="w-full text-xs font-semibold px-3 py-2.5 border border-slate-300 rounded-xl focus:border-[#d84e55] focus:outline-hidden">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Gender *</label>
                                                        <select name="passenger_gender" required class="w-full text-xs font-semibold px-3 py-2.5 border border-slate-300 rounded-xl focus:border-[#d84e55] focus:outline-hidden bg-white">
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                    <div>
                                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Mobile Phone *</label>
                                                        <input type="tel" name="contact_phone" required placeholder="Mobile Number" value="{{ Auth::user()?->phone ?? '+91 98100 12345' }}"
                                                               class="w-full text-xs font-semibold px-3 py-2.5 border border-slate-300 rounded-xl focus:border-[#d84e55] focus:outline-hidden">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Email *</label>
                                                        <input type="email" name="contact_email" required placeholder="Email Address" value="{{ Auth::user()?->email ?? 'rahul.sharma@gmail.com' }}"
                                                               class="w-full text-xs font-semibold px-3 py-2.5 border border-slate-300 rounded-xl focus:border-[#d84e55] focus:outline-hidden">
                                                    </div>
                                                </div>

                                                <!-- Fare Breakdown & Final Pay Button -->
                                                <div class="pt-3 border-t border-slate-100 bg-slate-50 p-3.5 rounded-2xl text-xs space-y-1.5">
                                                    <div class="flex justify-between text-slate-600">
                                                        <span>Base Fare (<span x-text="selectedSeats.length"></span> berths):</span>
                                                        <span>₹<span x-text="baseTotal"></span></span>
                                                    </div>
                                                    <div class="flex justify-between text-emerald-600 font-semibold" x-show="selectedSeats.length > 0">
                                                        <span>Return Offer / Coupon Discount:</span>
                                                        <span>- ₹<span x-text="totalDiscount"></span></span>
                                                    </div>
                                                    <div class="flex justify-between text-slate-600">
                                                        <span>GST (5% SAC 998555):</span>
                                                        <span>+ ₹<span x-text="gstAmount"></span></span>
                                                    </div>
                                                    <div class="flex justify-between text-sm font-black text-slate-900 pt-2 border-t border-slate-200">
                                                        <span>Grand Total:</span>
                                                        <span class="text-[#d84e55] text-lg font-black">₹<span x-text="grandTotal"></span></span>
                                                    </div>
                                                </div>

                                                <button type="submit"
                                                        :disabled="selectedSeats.length === 0"
                                                        class="w-full py-3.5 bg-[#d84e55] hover:bg-[#c13b42] disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-black text-xs sm:text-sm rounded-xl shadow-lg shadow-red-600/30 transition flex items-center justify-center gap-2">
                                                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                                                    <span>CONFIRM & BOOK TICKET (₹<span x-text="grandTotal"></span>)</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </main>
        </div>
    </div>
</section>
@endsection
