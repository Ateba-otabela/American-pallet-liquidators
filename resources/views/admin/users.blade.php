@extends('layouts.admin')

@section('admin_content')
    <div class="space-y-6">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-black uppercase tracking-tight text-zinc-950">Registered Users</h2>
                <p class="text-sm text-zinc-500 mt-1 font-semibold">All customer accounts on the platform</p>
            </div>
            <!-- User Count Badge -->
            <div class="flex items-center gap-3">
                <div class="bg-zinc-950 text-white px-5 py-2.5 rounded-lg flex items-center gap-3 shadow">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <span class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest leading-none">Total Customers</span>
                        <span class="block text-2xl font-black text-white leading-tight">{{ $usersCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-[10px] font-black uppercase tracking-wider text-zinc-400">
                            <th class="px-5 py-4">#</th>
                            <th class="px-5 py-4">Name</th>
                            <th class="px-5 py-4">Email Address</th>
                            <th class="px-5 py-4">Role</th>
                            <th class="px-5 py-4">Total Orders</th>
                            <th class="px-5 py-4">Joined</th>
                            <th class="px-5 py-4">Verified</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-100">
                                <!-- ID -->
                                <td class="px-5 py-4 text-zinc-400 font-bold text-xs">
                                    #{{ $user->id }}
                                </td>

                                <!-- Name + Avatar -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-zinc-950 text-white flex items-center justify-center font-black text-sm flex-shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-zinc-900">{{ $user->name }}</span>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-5 py-4 text-zinc-600 font-semibold">
                                    <a href="mailto:{{ $user->email }}" class="hover:text-zinc-950 hover:underline transition">{{ $user->email }}</a>
                                </td>

                                <!-- Role Badge -->
                                <td class="px-5 py-4">
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center gap-1 bg-violet-50 text-violet-700 border border-violet-200 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">
                                            <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-zinc-50 text-zinc-600 border border-zinc-200 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">
                                            <span class="h-1.5 w-1.5 rounded-full bg-zinc-400"></span>
                                            Customer
                                        </span>
                                    @endif
                                </td>

                                <!-- Orders Count -->
                                <td class="px-5 py-4">
                                    <span class="font-extrabold text-zinc-950">{{ $user->orders_count }}</span>
                                    <span class="text-zinc-400 text-xs font-semibold ml-1">{{ Str::plural('order', $user->orders_count) }}</span>
                                </td>

                                <!-- Joined Date -->
                                <td class="px-5 py-4 text-zinc-500 font-semibold text-xs">
                                    {{ optional($user->created_at)->format('M d, Y') ?: 'N/A' }}
                                </td>

                                <!-- Email Verified -->
                                <td class="px-5 py-4">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 border border-emerald-200 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 border border-amber-200 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            Unverified
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center text-zinc-400 font-semibold text-sm">
                                    No registered users yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4 text-xs font-semibold text-zinc-500">
                    <span>
                        Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
                    </span>
                    <div class="flex items-center gap-1">
                        {{-- Previous --}}
                        @if($users->onFirstPage())
                            <span class="px-3 py-1.5 rounded border border-gray-200 text-zinc-300 cursor-not-allowed">&larr;</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 rounded border border-gray-200 text-zinc-600 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition">&larr;</a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                            @if($page == $users->currentPage())
                                <span class="px-3 py-1.5 rounded bg-zinc-950 text-white border border-zinc-950">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 rounded border border-gray-200 text-zinc-600 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 rounded border border-gray-200 text-zinc-600 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition">&rarr;</a>
                        @else
                            <span class="px-3 py-1.5 rounded border border-gray-200 text-zinc-300 cursor-not-allowed">&rarr;</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
