@extends('layouts.app')

@section('title', "Live Bus GPS Tracking - PNR {$booking->pnr_number} | NANDAN BUS")

@section('content')
<div class="py-12 bg-slate-900 text-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        <!-- Live GPS Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-800 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>LIVE GPS ACTIVE • ON TIME</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Live Bus Tracking</h1>
                <p class="text-xs text-slate-400 mt-1">PNR: <strong class="text-amber-400 font-mono">{{ $booking->pnr_number }}</strong> • Seat: <strong class="text-white">{{ $booking->seat_number }}</strong></p>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-[10px] text-slate-400 uppercase font-bold block">Vehicle Number</span>
                <span class="text-lg font-mono font-extrabold text-white">{{ $booking->schedule->fleet->bus_number }}</span>
                <span class="text-xs text-slate-400 block">{{ $booking->schedule->fleet->bus_name }}</span>
            </div>
        </div>

        <!-- Simulated Radar / Map View Card -->
        <div class="mt-8 bg-slate-950 rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-red-600/10 blur-3xl pointer-events-none"></div>

            <!-- Telemetry Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Current Speed</span>
                    <span class="text-2xl font-extrabold text-emerald-400 mt-1 block">78 <span class="text-xs font-normal text-slate-400">km/h</span></span>
                </div>

                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Highway Corridor</span>
                    <span class="text-base font-extrabold text-white mt-1 block">NH 44 Expressway</span>
                </div>

                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Captain on Board</span>
                    <span class="text-base font-extrabold text-white mt-1 block">Sukhwinder Singh</span>
                </div>

                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Next Stop ETA</span>
                    <span class="text-base font-extrabold text-amber-400 mt-1 block">35 mins</span>
                </div>
            </div>

            <!-- Route Stop Milestones -->
            <div class="relative pl-6 border-l-2 border-slate-800 space-y-8 my-4 ml-4">
                
                <!-- Stop 1: Departure -->
                <div class="relative">
                    <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-4 border-slate-950"></div>
                    <div class="flex items-center justify-between">
                        <span class="font-extrabold text-sm text-white">{{ $booking->schedule->route->source_city }} (Boarding Hub)</span>
                        <span class="text-xs font-bold text-emerald-400">DEPARTED ON TIME</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $booking->boarding_point }}</p>
                </div>

                <!-- Stop 2: Live GPS Position -->
                <div class="relative">
                    <div class="absolute -left-[33px] top-0.5 w-5 h-5 rounded-full bg-red-500 border-4 border-slate-950 animate-pulse"></div>
                    <div class="bg-red-950/40 p-4 rounded-2xl border border-red-500/30">
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold text-sm text-red-300 flex items-center gap-2">
                                <i data-lucide="bus" class="w-4 h-4 text-red-400"></i> Current Bus Location
                            </span>
                            <span class="text-xs font-mono font-bold text-amber-400">Crossing Toll Plaza Km 142</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Bus traveling smoothly at steady speed. Next 20-min dinner rest stop scheduled shortly.</p>
                    </div>
                </div>

                <!-- Stop 3: Final Destination -->
                <div class="relative">
                    <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-700 border-4 border-slate-950"></div>
                    <div class="flex items-center justify-between">
                        <span class="font-extrabold text-sm text-slate-300">{{ $booking->schedule->route->destination_city }}</span>
                        <span class="text-xs font-bold text-slate-500">SCHEDULED ARRIVAL</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $booking->dropping_point }}</p>
                </div>
            </div>

            <!-- Captain Contact & Emergency Bar -->
            <div class="mt-8 pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-300">
                        <i data-lucide="user-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-white block">Captain Contact Hotline</span>
                        <span class="text-xs text-slate-400">{{ $booking->schedule->fleet->operator->contact_phone }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="https://wa.me/?text={{ urlencode('Tracking my bus journey on NANDAN BUS. PNR: ' . $booking->pnr_number . ' - ' . url()->current()) }}"
                       target="_blank"
                       class="flex-1 sm:flex-none px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5">
                        <i data-lucide="share-2" class="w-4 h-4"></i> Share Location
                    </a>

                    <a href="{{ route('buses.confirmation', $booking->pnr_number) }}"
                       class="flex-1 sm:flex-none px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl border border-slate-700 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="ticket" class="w-4 h-4"></i> View M-Ticket
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
