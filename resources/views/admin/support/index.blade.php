@extends('layouts.admin')

@section('title', 'Support Center')

@section('admin_content')
    <div class="space-y-6">
        <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight">Support Center</h2>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-black uppercase tracking-wider text-zinc-400 border-b border-gray-100">
                            <th class="p-4">Customer</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">AI Active</th>
                            <th class="p-4">Last Activity</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-semibold">
                        @forelse($conversations as $conv)
                            <tr class="{{ $conv->needs_admin ? 'bg-rose-50/30' : '' }}">
                                <td class="p-4">
                                    <span class="block text-zinc-950 font-bold">{{ $conv->customer_name ?? 'Guest' }}</span>
                                    <span class="block text-zinc-400 text-[10px]">{{ $conv->customer_email ?? 'No email' }}</span>
                                    @if($conv->needs_admin)
                                        <span class="inline-block mt-1 bg-red-100 text-red-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">Needs Human</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                        {{ $conv->status === 'Open' ? 'bg-blue-50 text-blue-600' : '' }}
                                        {{ $conv->status === 'Waiting' ? 'bg-amber-50 text-amber-600' : '' }}
                                        {{ $conv->status === 'Closed' ? 'bg-gray-100 text-gray-600' : '' }}
                                    ">{{ $conv->status }}</span>
                                </td>
                                <td class="p-4">
                                    @if($conv->ai_active)
                                        <span class="text-emerald-500 font-bold flex items-center gap-1 text-[11px] uppercase"><span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Active</span>
                                    @else
                                        <span class="text-zinc-400 font-bold flex items-center gap-1 text-[11px] uppercase"><span class="w-2 h-2 rounded-full bg-zinc-300"></span> Paused</span>
                                    @endif
                                </td>
                                <td class="p-4 text-zinc-500 text-xs">
                                    {{ $conv->last_activity ? $conv->last_activity->diffForHumans() : 'Never' }}
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('admin.support.show', $conv) }}" class="bg-zinc-950 text-white px-3 py-1.5 rounded text-[10px] font-extrabold uppercase hover:bg-zinc-800 transition">View Chat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-zinc-400 font-bold">No active conversations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $conversations->links() }}
        </div>
    </div>
@endsection
