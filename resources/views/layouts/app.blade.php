<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NANDAN BUS - Online Bus Ticket Booking, Volvo Sleeper & Low Fares')</title>
    <meta name="description"
        content="@yield('meta_description', 'Book intercity bus tickets online with live seat selection, Volvo AC sleeper coaches, GPS bus tracking and lowest fare guarantee.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-serif-display {
            font-family: 'Playfair Display', serif;
        }

        /* redBus style custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #d84e55;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #b83238;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#f7f7f7] text-[#3e3e52] antialiased flex flex-col min-h-screen pb-16 md:pb-0">

    <!-- redBus Global Announcement Bar -->
    <div class="bg-[#1d2129] text-white/90 text-xs py-2 px-4 border-b border-slate-800">
        <div
            class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 text-amber-400 font-semibold whitespace-nowrap">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 shrink-0 text-amber-400"></i>
                    <span>Special Offer: Use code <strong
                            class="bg-amber-400/20 px-1.5 py-0.5 rounded text-amber-300 font-bold">NANDAN5000</strong>
                        for instant discount on luxury coaches!</span>
                </span>
            </div>
            <div class="flex items-center gap-4 sm:gap-5 text-slate-300 text-[11px] font-medium whitespace-nowrap">
                <a href="tel:+911145678900" class="hover:text-white flex items-center gap-1.5 transition">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-red-400 shrink-0"></i> 24x7 Helpline: +91 11 4567
                    8900
                </a>
                <span class="text-slate-700">|</span>
                @if(Auth::check() && Auth::user()->isAgent())
                    <a href="{{ route('agent.dashboard') }}" class="text-amber-400 font-bold hover:underline">B2B Agent
                        Portal</a>
                @elseif(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isStaff()))
                    <a href="{{ route('admin.dashboard') }}" class="text-amber-400 font-bold hover:underline">Admin Command
                        HQ</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-white text-slate-400">Agent Login</a>
                @endif
            </div>
        </div>
    </div>

    <!-- redBus Primary Sticky Header -->
    <header class="bg-white sticky top-0 z-50 border-b border-slate-200 shadow-xs" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">

                <!-- Brand Logo (redBus Style) -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                        <div
                            class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-red-600 to-rose-700 flex items-center justify-center text-white shadow-md shadow-red-500/20 group-hover:scale-105 transition-transform">
                            <i data-lucide="bus" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold tracking-tight text-slate-900 block leading-none">
                                NANDAN<span class="text-red-600">BUS</span>
                            </span>
                            <span class="text-[9px] tracking-widest text-slate-400 uppercase font-extrabold block mt-1">
                                An Indian Travel ERP Platform
                            </span>
                        </div>
                    </a>

                    <!-- Navigation Tabs: Exclusively Bus & Tour Travel -->
                    <nav class="hidden lg:flex items-center gap-2 text-sm font-bold text-slate-700">
                        <!-- Bus Tickets -->
                        <a href="{{ route('buses.index') }}"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-2xl transition {{ request()->routeIs('buses.*') || request()->routeIs('home') ? 'bg-red-50 text-red-600 shadow-2xs font-extrabold border border-red-200' : 'hover:bg-slate-50 hover:text-red-600' }}">
                            <div class="w-7 h-7 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                                <i data-lucide="bus" class="w-4 h-4"></i>
                            </div>
                            <span>Bus Tickets</span>
                        </a>

                        <!-- Holiday Tours & Packages -->
                        <a href="{{ route('packages.index') }}"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-2xl transition {{ request()->routeIs('packages.*') ? 'bg-red-50 text-red-600 shadow-2xs font-extrabold border border-red-200' : 'hover:bg-slate-50 hover:text-red-600' }}">
                            <div class="w-7 h-7 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                                <i data-lucide="palmtree" class="w-4 h-4"></i>
                            </div>
                            <span>Holiday Tours</span>
                        </a>

                        <!-- Live GPS Bus Tracking -->
                        <a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Manali', 'date' => date('Y-m-d')]) }}"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-2xl transition hover:bg-slate-50 hover:text-red-600">
                            <div class="w-7 h-7 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                                <i data-lucide="navigation" class="w-4 h-4"></i>
                            </div>
                            <span>Live Bus Tracker</span>
                        </a>

                        <!-- About NANDAN TOURS -->
                        <a href="{{ route('about') }}"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-2xl transition {{ request()->routeIs('about') ? 'bg-red-50 text-red-600 shadow-2xs font-extrabold border border-red-200' : 'hover:bg-slate-50 hover:text-red-600' }}">
                            <div class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                                <i data-lucide="info" class="w-4 h-4"></i>
                            </div>
                            <span>About Us</span>
                        </a>
                    </nav>
                </div>

                <!-- Right Utility Bar (Help & Account) -->
                <div class="hidden lg:flex items-center gap-4">
                    <!-- Help Center -->
                    <a href="{{ route('contact') }}"
                        class="flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-red-600 px-3 py-2 rounded-xl hover:bg-slate-50 transition">
                        <i data-lucide="headset" class="w-4 h-4 text-slate-500"></i>
                        <span>Help</span>
                    </a>

                    <!-- Account Dropdown (redBus Style) -->
                    <div class="relative" x-data="{ openAccount: false }" @mouseleave="openAccount = false">
                        <button @click="openAccount = !openAccount"
                            class="flex items-center gap-2 px-3.5 py-2 rounded-2xl border border-slate-200 bg-white hover:border-slate-300 transition text-xs font-extrabold text-slate-800 shadow-2xs">
                            <i data-lucide="user" class="w-4 h-4 text-red-600"></i>
                            <span>{{ Auth::check() ? Auth::user()->name : 'Account' }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                        </button>

                        <div x-show="openAccount" x-transition.opacity.duration.150ms
                            class="absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 py-3 z-50 text-xs">
                            @if(Auth::check())
                                <div class="px-4 py-2.5 border-b border-slate-100 mb-1.5">
                                    <div class="font-extrabold text-slate-900 truncate">{{ Auth::user()->name }}</div>
                                    <div class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</div>
                                </div>

                                @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 font-bold text-amber-600">
                                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Admin CRM HQ
                                    </a>
                                @elseif(Auth::user()->isAgent())
                                    <a href="{{ route('agent.dashboard') }}"
                                        class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 font-bold text-teal-600">
                                        <i data-lucide="briefcase" class="w-4 h-4"></i> B2B Partner Portal
                                    </a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}"
                                        class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 font-bold text-red-600">
                                        <i data-lucide="layout" class="w-4 h-4"></i> Traveller Dashboard
                                    </a>
                                    <a href="{{ route('customer.bookings') }}"
                                        class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-700 font-semibold">
                                        <i data-lucide="ticket" class="w-4 h-4 text-slate-400"></i> My Bus & Tour Bookings
                                    </a>
                                    <a href="{{ route('customer.passengers') }}"
                                        class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-700 font-semibold">
                                        <i data-lucide="users" class="w-4 h-4 text-slate-400"></i> Saved Co-Travellers
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-2"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center gap-2.5 px-4 py-2 hover:bg-rose-50 text-rose-600 font-bold">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> Sign Out
                                    </button>
                                </form>
                            @else
                                <div class="p-3 text-center border-b border-slate-100">
                                    <a href="{{ route('login') }}"
                                        class="block w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold rounded-xl shadow-xs transition">
                                        Log In / Sign Up
                                    </a>
                                </div>
                                <div class="pt-2">
                                    <a href="{{ route('customer.bookings') }}"
                                        class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-700 font-semibold">
                                        <i data-lucide="ticket" class="w-4 h-4 text-slate-400"></i> Show My Ticket
                                    </a>
                                    <a href="{{ route('contact') }}"
                                        class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-700 font-semibold">
                                        <i data-lucide="ban" class="w-4 h-4 text-slate-400"></i> Cancel Ticket
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Hamburger -->
                <div class="flex items-center gap-2 lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-xl text-slate-700 hover:bg-slate-100">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileMenuOpen" x-transition
            class="lg:hidden bg-white border-b border-slate-200 px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('buses.index') }}"
                class="flex items-center gap-3 p-3 bg-red-50 text-red-700 font-bold rounded-xl text-sm">
                <i data-lucide="bus" class="w-5 h-5"></i> Bus Tickets
            </a>
            <a href="{{ route('packages.index') }}"
                class="flex items-center gap-3 p-3 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-sm">
                <i data-lucide="palmtree" class="w-5 h-5 text-teal-600"></i> Holiday Tours & Packages
            </a>
            <a href="{{ route('about') }}"
                class="flex items-center gap-3 p-3 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-sm">
                <i data-lucide="info" class="w-5 h-5 text-slate-600"></i> About NANDAN TOURS
            </a>
            <a href="{{ route('contact') }}"
                class="flex items-center gap-3 p-3 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-sm">
                <i data-lucide="headset" class="w-5 h-5 text-amber-600"></i> 24x7 Customer Support
            </a>
            <div class="border-t border-slate-100 pt-3 flex gap-2">
                @if(Auth::check())
                    <a href="{{ route('customer.dashboard') }}"
                        class="flex-1 py-2.5 text-center bg-slate-900 text-white font-bold rounded-xl text-xs">My
                        Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="flex-1 py-2.5 text-center bg-red-600 text-white font-bold rounded-xl text-xs">Sign In</a>
                    <a href="{{ route('register') }}"
                        class="flex-1 py-2.5 text-center bg-slate-100 text-slate-800 font-bold rounded-xl text-xs">Register</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Injection -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- redBus Authentic 4-Column Footer -->
    <footer class="bg-[#1d2129] text-white pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-800">

                <!-- Col 1: Top Bus Routes -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-red-400 mb-4">Top Bus Routes</h4>
                    <ul class="space-y-2.5 text-xs text-slate-300">
                        <li><a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Manali', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Delhi to Manali Bus</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Jaipur', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Delhi to Jaipur Bus</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Bangalore', 'to' => 'Goa', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Bangalore to Goa Bus</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Mumbai', 'to' => 'Pune', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Mumbai to Pune Bus</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Bangalore', 'to' => 'Hyderabad', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Bangalore to Hyderabad Bus</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Shimla', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Delhi to Shimla Bus</a></li>
                    </ul>
                </div>

                <!-- Col 2: Top Bus Cities -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-red-400 mb-4">Top Bus Cities</h4>
                    <ul class="space-y-2.5 text-xs text-slate-300">
                        <li><a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Manali', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">New Delhi Bus Terminals</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Bangalore', 'to' => 'Goa', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Bangalore Majestic & Madiwala</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Mumbai', 'to' => 'Pune', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Mumbai Dadar & Vashi</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Jaipur', 'to' => 'Delhi', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Jaipur Sindhi Camp</a></li>
                        <li><a href="{{ route('buses.search', ['from' => 'Hyderabad', 'to' => 'Bangalore', 'date' => date('Y-m-d')]) }}"
                                class="hover:text-red-400 transition">Hyderabad Ameerpet & MGBS</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-red-400 transition">All 50+
                                Tourist Cities</a></li>
                    </ul>
                </div>

                <!-- Col 3: State RTC Buses & Fleets -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-red-400 mb-4">Official RTC & Fleets
                    </h4>
                    <ul class="space-y-2.5 text-xs text-slate-300">
                        <li><span class="text-white font-bold">NANDAN TOURS Luxury Fleet</span></li>
                        <li><span>UPSRTC (Uttar Pradesh Transport)</span></li>
                        <li><span>HRTC (Himachal Roadways)</span></li>
                        <li><span>RSRTC (Rajasthan State Roadways)</span></li>
                        <li><span>KSRTC (Karnataka State Transport)</span></li>
                        <li><span>Zingbus Electric & VRL Travels</span></li>
                    </ul>
                </div>

                <!-- Col 4: About NANDAN BUS & Contact -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-red-400 mb-4">About NANDAN BUS</h4>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        India's fast-growing bus ticketing and travel management firm. Authorized online booking partner
                        for private Volvo luxury coaches and State RTCs across 100,000+ routes with live seat layout
                        selection.
                    </p>
                    <div class="text-xs space-y-1.5 text-slate-400">
                        <div class="flex items-center gap-2">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-red-400"></i>
                            <span>contact@nandantours.com</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-red-400"></i>
                            <span>24x7 Support: +91 11 4567 8900</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Security Badges -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} NANDAN BUS (NANDAN TOURS ERP). All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('about') }}" class="hover:text-slate-300">About Us</a>
                    <a href="{{ route('contact') }}" class="hover:text-slate-300">Contact Support</a>
                    <a href="{{ route('login') }}" class="hover:text-slate-300">Staff CRM</a>
                    <a href="{{ route('agent.dashboard') }}" class="hover:text-slate-300">Agent Portal</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- redBus Global Mobile Bottom Navigation Bar (Mobile Native App Style) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 z-40 flex items-center justify-around px-2 shadow-2xl">
        <!-- Buses Tab -->
        <a href="{{ route('buses.index') }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition {{ request()->routeIs('buses.*') || request()->routeIs('home') ? 'text-[#d84e55]' : 'text-slate-400 hover:text-slate-600' }}">
            <i data-lucide="bus" class="w-5 h-5 {{ request()->routeIs('buses.*') || request()->routeIs('home') ? 'stroke-[2.5]' : '' }}"></i>
            <span class="text-[10px] font-bold mt-1">Buses</span>
        </a>

        <!-- Live Bus Track Tab -->
        <a href="{{ route('buses.search', ['from' => 'Delhi', 'to' => 'Manali', 'date' => date('Y-m-d')]) }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition text-slate-400 hover:text-slate-600">
            <i data-lucide="navigation" class="w-5 h-5"></i>
            <span class="text-[10px] font-bold mt-1">Live Track</span>
        </a>

        <!-- Packages Tab -->
        <a href="{{ route('packages.index') }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition {{ request()->routeIs('packages.*') ? 'text-[#d84e55]' : 'text-slate-400 hover:text-slate-600' }}">
            <i data-lucide="palmtree" class="w-5 h-5"></i>
            <span class="text-[10px] font-bold mt-1">Holidays</span>
        </a>

        <!-- Help Tab -->
        <a href="{{ route('contact') }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition {{ request()->routeIs('contact') ? 'text-[#d84e55]' : 'text-slate-400 hover:text-slate-600' }}">
            <i data-lucide="headset" class="w-5 h-5"></i>
            <span class="text-[10px] font-bold mt-1">Help</span>
        </a>

        <!-- Account Tab -->
        <a href="{{ Auth::check() ? (Auth::user()->isAdmin() ? route('admin.dashboard') : route('agent.dashboard')) : route('login') }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition {{ request()->routeIs('login') ? 'text-[#d84e55]' : 'text-slate-400 hover:text-slate-600' }}">
            <i data-lucide="user" class="w-5 h-5"></i>
            <span class="text-[10px] font-bold mt-1">{{ Auth::check() ? 'Profile' : 'Account' }}</span>
        </a>
    </nav>

    @stack('scripts')
</body>

</html>