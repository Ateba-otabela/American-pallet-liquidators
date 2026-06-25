@extends('layouts.admin')

@section('admin_content')
    <div class="space-y-6">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md font-bold text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-black uppercase tracking-tight text-zinc-950">Email Subscribers</h2>
                <p class="text-sm text-zinc-500 mt-1 font-semibold">All newsletter & notification subscribers</p>
            </div>
            <!-- Count Badge -->
            <div class="flex items-center gap-3">
                <div class="bg-zinc-950 text-white px-5 py-2.5 rounded-lg flex items-center gap-3 shadow">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <span class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest leading-none">Total Subscribers</span>
                        <span class="block text-2xl font-black text-white leading-tight">{{ $subscribersCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscribers Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-[10px] font-black uppercase tracking-wider text-zinc-400">
                            <th class="px-5 py-4">#</th>
                            <th class="px-5 py-4">Email Address</th>
                            <th class="px-5 py-4">Subscribed On</th>
                            <th class="px-5 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($subscribers as $subscriber)
                            <tr class="hover:bg-gray-50 transition-colors duration-100">

                                <!-- Row number -->
                                <td class="px-5 py-4 text-zinc-400 font-bold text-xs">
                                    #{{ $subscriber->id }}
                                </td>

                                <!-- Email with icon -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-zinc-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="h-4 w-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <a href="mailto:{{ $subscriber->email }}" class="font-semibold text-zinc-800 hover:text-zinc-950 hover:underline transition">
                                            {{ $subscriber->email }}
                                        </a>
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-5 py-4 text-zinc-500 font-semibold text-xs">
                                    {{ optional($subscriber->created_at)->format('M d, Y · g:i A') ?: 'N/A' }}
                                </td>

                                <!-- Delete action -->
                                <td class="px-5 py-4 text-right">
                                    <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST"
                                          onsubmit="return confirm('Remove {{ addslashes($subscriber->email) }} from subscribers?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded border border-red-200 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white hover:border-red-600 transition duration-150">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Remove
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-16 text-center text-zinc-400 font-semibold text-sm">
                                    No subscribers yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($subscribers->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4 text-xs font-semibold text-zinc-500">
                    <span>
                        Showing {{ $subscribers->firstItem() }}–{{ $subscribers->lastItem() }} of {{ $subscribers->total() }} subscribers
                    </span>
                    <div class="flex items-center gap-1">
                        {{-- Previous --}}
                        @if($subscribers->onFirstPage())
                            <span class="px-3 py-1.5 rounded border border-gray-200 text-zinc-300 cursor-not-allowed">&larr;</span>
                        @else
                            <a href="{{ $subscribers->previousPageUrl() }}" class="px-3 py-1.5 rounded border border-gray-200 text-zinc-600 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition">&larr;</a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($subscribers->getUrlRange(max(1, $subscribers->currentPage() - 2), min($subscribers->lastPage(), $subscribers->currentPage() + 2)) as $page => $url)
                            @if($page == $subscribers->currentPage())
                                <span class="px-3 py-1.5 rounded bg-zinc-950 text-white border border-zinc-950">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 rounded border border-gray-200 text-zinc-600 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($subscribers->hasMorePages())
                            <a href="{{ $subscribers->nextPageUrl() }}" class="px-3 py-1.5 rounded border border-gray-200 text-zinc-600 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition">&rarr;</a>
                        @else
                            <span class="px-3 py-1.5 rounded border border-gray-200 text-zinc-300 cursor-not-allowed">&rarr;</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
