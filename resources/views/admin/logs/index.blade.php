@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-zinc-950 uppercase">Visitor Analytics Logs</h1>
            <p class="text-sm text-zinc-500 mt-1">Real-time visitor telemetry tracking browser types, operating systems, locations, and hardware info.</p>
        </div>
        
        <form method="POST" action="{{ route('admin.logs.clear') }}" onsubmit="return confirm('Are you sure you want to permanently clear all logs?');">
            @csrf
            <button type="submit" class="flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded shadow transition duration-150">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Clear Telemetry Logs
            </button>
        </form>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <form method="GET" action="{{ route('admin.logs') }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-1/3">
                <label for="start_date" class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-1.5">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="w-full text-xs font-semibold border-gray-300 rounded-lg shadow-sm focus:ring-zinc-950 focus:border-zinc-950 px-3 py-2 border">
            </div>
            <div class="w-full md:w-1/3">
                <label for="end_date" class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-1.5">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="w-full text-xs font-semibold border-gray-300 rounded-lg shadow-sm focus:ring-zinc-950 focus:border-zinc-950 px-3 py-2 border">
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto bg-zinc-950 hover:bg-zinc-900 text-white font-bold text-xs uppercase px-5 py-2.5 rounded shadow transition duration-150">
                    Apply Filter
                </button>
                @if(!empty($startDate) || !empty($endDate))
                    <a href="{{ route('admin.logs') }}" class="w-full md:w-auto text-center bg-zinc-100 hover:bg-zinc-200 text-zinc-800 font-bold text-xs uppercase px-5 py-2.5 rounded transition duration-150">
                        Clear Filter
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Telemetry Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block">Total Page Views</span>
                <span class="text-3xl font-black text-zinc-950 mt-1 block">{{ number_format($totalVisits) }}</span>
            </div>
            <div class="bg-zinc-100 p-3 rounded-lg text-zinc-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block">Unique Visitors</span>
                <span class="text-3xl font-black text-zinc-950 mt-1 block">{{ number_format($uniqueIPs) }}</span>
            </div>
            <div class="bg-emerald-50 p-3 rounded-lg text-emerald-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block">Mobile Phones</span>
                <span class="text-3xl font-black text-zinc-950 mt-1 block">
                    {{ number_format($mobileVisits) }} 
                    <span class="text-xs font-semibold text-zinc-400">
                        ({{ $totalVisits > 0 ? round(($mobileVisits / $totalVisits) * 100) : 0 }}%)
                    </span>
                </span>
            </div>
            <div class="bg-indigo-50 p-3 rounded-lg text-indigo-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block">Desktop PC / Tablets</span>
                <span class="text-3xl font-black text-zinc-950 mt-1 block">
                    {{ number_format($desktopVisits + $tabletVisits) }}
                    <span class="text-xs font-semibold text-zinc-400">
                        ({{ $totalVisits > 0 ? round((($desktopVisits + $tabletVisits) / $totalVisits) * 100) : 0 }}%)
                    </span>
                </span>
            </div>
            <div class="bg-amber-50 p-3 rounded-lg text-amber-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
        
    </div>

    <!-- Alert / Status banners -->
    @if(session('success'))
    <div class="bg-emerald-500 text-white font-bold p-4 rounded shadow-sm flex items-center gap-3">
        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Telemetry Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-sm font-black text-zinc-900 uppercase tracking-wider">Activity Feed (Latest Requests)</h2>
            <span class="bg-zinc-900 text-white text-[10px] font-black uppercase px-2 py-0.5 rounded-full">Live Tracker</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-50 border-b border-gray-200 text-zinc-600 text-[10px] font-black uppercase tracking-wider">
                        <th class="px-6 py-3.5">Timestamp</th>
                        <th class="px-6 py-3.5">Device (Phone/PC Details)</th>
                        <th class="px-6 py-3.5">Location (IP)</th>
                        <th class="px-6 py-3.5">Visited URL</th>
                        <th class="px-6 py-3.5">Browser & OS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/60 transition duration-75">
                        <!-- Timestamp -->
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-zinc-500">
                            {{ $log->created_at->setTimezone('America/New_York')->format('M d, Y — h:i:s A') }} EST
                        </td>
                        
                        <!-- Device Details -->
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-zinc-900">
                            <div class="flex items-center gap-2.5">
                                @if($log->device_type === 'Mobile')
                                    <span class="bg-indigo-50 text-indigo-700 p-1.5 rounded-md flex items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </span>
                                @elseif($log->device_type === 'Tablet')
                                    <span class="bg-amber-50 text-amber-700 p-1.5 rounded-md flex items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </span>
                                @else
                                    <span class="bg-zinc-100 text-zinc-700 p-1.5 rounded-md flex items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </span>
                                @endif
                                <div class="flex flex-col">
                                    <span class="font-semibold text-zinc-950 text-xs">{{ $log->user_agent }}</span>
                                    <span class="text-[9px] uppercase tracking-wider font-extrabold text-zinc-400 mt-0.5">{{ $log->device_type }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Location & IP -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="font-bold text-xs text-zinc-900 flex items-center gap-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $log->location }}
                                </span>
                                <span class="text-[10px] text-zinc-400 font-semibold tracking-normal mt-0.5">{{ $log->ip_address }}</span>
                            </div>
                        </td>

                        <!-- Visited URL -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-zinc-100 text-zinc-800 font-mono text-[11px] px-2.5 py-1 rounded border border-zinc-200">
                                {{ $log->path }}
                            </span>
                        </td>

                        <!-- OS & Browser Details -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="bg-slate-100 text-slate-800 text-[10px] font-black uppercase px-2 py-0.5 rounded">
                                    {{ $log->browser }}
                                </span>
                                <span class="bg-blue-50 text-blue-800 text-[10px] font-black uppercase px-2 py-0.5 rounded">
                                    {{ $log->os }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-zinc-400 font-bold">
                            No logs registered yet. Visit the live storefront to populate telemetry feeds!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-zinc-50/50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
