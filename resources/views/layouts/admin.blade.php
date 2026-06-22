<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Portal — American Pallet Liquidators</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind + Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-slate-800 antialiased min-h-screen flex overflow-x-hidden" x-data="{ sidebarOpen: false }" x-init="$watch('sidebarOpen', value => document.body.style.overflow = value ? 'hidden' : '')">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-30 bg-zinc-950/40 md:hidden" 
         x-cloak></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-zinc-950 text-zinc-400 flex flex-col justify-between transition-transform duration-300 md:translate-x-0 flex-shrink-0 shadow-xl border-r border-zinc-900">
        
        <!-- Top brand and navigation links -->
        <div>
            <!-- Header Brand -->
            <div class="h-20 flex items-center px-6 border-b border-zinc-900 gap-2">
                <span class="bg-white text-zinc-950 px-2.5 py-1 rounded font-black text-lg tracking-tight">APL</span>
                <div class="flex flex-col">
                    <span class="text-white font-extrabold text-sm leading-none tracking-tight">ADMIN PANEL</span>
                    <span class="text-zinc-600 font-bold text-[9px] uppercase tracking-widest leading-none mt-0.5">Control Center</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded transition-colors duration-150
                    {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900 text-white' : 'hover:bg-zinc-900 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-4 py-3 rounded transition-colors duration-150
                    {{ request()->routeIs('admin.products*') ? 'bg-zinc-900 text-white' : 'hover:bg-zinc-900 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Inventory (Products)</span>
                </a>

                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-4 py-3 rounded transition-colors duration-150
                    {{ request()->routeIs('admin.categories*') ? 'bg-zinc-900 text-white' : 'hover:bg-zinc-900 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Categories</span>
                </a>

                <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded transition-colors duration-150
                    {{ request()->routeIs('admin.orders*') ? 'bg-zinc-900 text-white' : 'hover:bg-zinc-900 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Orders (Sales)</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded transition-colors duration-150
                    {{ request()->routeIs('admin.settings*') ? 'bg-zinc-900 text-white' : 'hover:bg-zinc-900 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>General Settings</span>
                </a>

                <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-3 rounded transition-colors duration-150
                    {{ request()->routeIs('admin.logs*') ? 'bg-zinc-900 text-white' : 'hover:bg-zinc-900 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                    <span>Visitor Logs</span>
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded transition-colors duration-150
                    {{ request()->routeIs('admin.users*') ? 'bg-zinc-900 text-white' : 'hover:bg-zinc-900 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Users</span>
                </a>
            </nav>
        </div>

        <!-- Bottom details: Live site and Logout -->
        <div class="p-4 border-t border-zinc-900 space-y-1.5 text-sm font-semibold">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded text-zinc-400 hover:bg-zinc-900 hover:text-white transition duration-150">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>View Live Site</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 rounded text-rose-500 hover:bg-rose-500/10 transition duration-150 font-bold">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Workspace Area -->
    <div class="flex-grow flex flex-col min-h-screen">
        
        <!-- Top Workspace Bar -->
        <header class="h-20 bg-white border-b border-gray-200 flex justify-between items-center px-6 sm:px-8 shadow-sm">
            <div class="flex items-center gap-4">
                <!-- Mobile Burger Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-zinc-600 hover:text-zinc-950 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-black uppercase tracking-tight text-zinc-900 hidden sm:block">Control Center</h1>
            </div>

            <!-- Profile Info -->
            <div class="flex items-center gap-3">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <span class="text-sm font-semibold text-zinc-700">Administrator</span>
            </div>
        </header>

        <!-- Main slot workspace content -->
        <main class="flex-grow p-6 sm:p-8">
            @yield('admin_content')
        </main>
    </div>

</body>
</html>
