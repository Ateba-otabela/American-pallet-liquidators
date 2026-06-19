<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'America\'s Most Trusted Supplier of Liquidated Merchandise') | American Pallet Liquidators</title>
    <meta name="description" content="@yield('meta_description', 'Clone of American Pallet Liquidators (aplpallets.com). High piece count Amazon liquidation pallets, apparel pallets, pharmacy drug store HBA pallets, and national department store truckloads.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind + Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS is bundled with Breeze/Vite. Just in case, fallback or Alpine is loaded. -->
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden">

    <!-- Announcement Bar -->
    <div class="bg-zinc-950 text-white py-2.5 px-4 text-center text-xs font-semibold tracking-wider uppercase border-b border-zinc-800">
        <span>America's Most Trusted Supplier of Liquidated Merchandise — Call us today: </span>
        <a href="tel:5022081035" class="underline hover:text-zinc-300 transition duration-150">(502) 208-1035</a>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" x-data="{ open: false }" x-init="$watch('open', value => document.body.style.overflow = value ? 'hidden' : '')" @keydown.escape.window="open = false">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <span class="bg-zinc-950 text-white px-3 py-1.5 rounded font-black text-xl tracking-tight shadow-md group-hover:scale-105 transition-transform duration-200">APL</span>
                        <div class="flex flex-col">
                            <span class="text-zinc-900 font-extrabold text-sm sm:text-lg leading-none tracking-tight">AMERICAN PALLET</span>
                            <span class="text-zinc-500 font-bold text-[10px] sm:text-xs uppercase tracking-widest leading-none mt-0.5">LIQUIDATORS</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex space-x-8 text-sm font-semibold tracking-wide text-zinc-600">
                    <a href="{{ route('catalog') }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->routeIs('catalog') ? 'border-zinc-950 text-zinc-950' : 'border-transparent' }}">SHOP ALL</a>
                    <a href="{{ route('catalog', ['category' => 'pallets']) }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->filled('category') && request()->category == 'pallets' ? 'border-zinc-950 text-zinc-950' : 'border-transparent' }}">PALLETS</a>
                    <a href="{{ route('catalog', ['category' => 'truckloads']) }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->filled('category') && request()->category == 'truckloads' ? 'border-zinc-950 text-zinc-950' : 'border-transparent' }}">TRUCKLOADS</a>
                    <a href="{{ route('how-it-works') }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->routeIs('how-it-works') ? 'border-zinc-950 text-zinc-950' : 'border-transparent' }}">HOW IT WORKS</a>
                    <a href="{{ route('sell-to-us') }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->routeIs('sell-to-us') ? 'border-zinc-950 text-zinc-950' : 'border-transparent' }}">SELL TO US</a>
                    <a href="{{ route('faq') }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->routeIs('faq') ? 'border-zinc-950 text-zinc-950' : 'border-transparent' }}">FAQ</a>
                    <a href="{{ route('contact') }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->routeIs('contact') ? 'border-zinc-950 text-zinc-950' : 'border-transparent' }}">CONTACT</a>
                </nav>

                <!-- Header Actions -->
                <div class="flex items-center space-x-3 sm:space-x-6">
                    
                    <!-- Search Icon Button -->
                    <a href="{{ route('catalog') }}" class="text-zinc-500 hover:text-zinc-950 transition-colors duration-150 hidden sm:block">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </a>

                    <!-- User Account / Login -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-semibold text-zinc-700 hover:text-zinc-950 transition focus:outline-none">
                                <span>Hi, {{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50" x-cloak>
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-gray-100 font-semibold">Admin Panel</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-gray-100">My Dashboard</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-gray-100">Profile Settings</a>
                                <hr class="border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold tracking-wide text-zinc-600 hover:text-zinc-950 transition duration-150 hidden sm:block">SIGN IN</a>
                    @endauth

                    <!-- Cart Icon with badge count -->
                    <a href="{{ route('cart.index') }}" class="relative text-zinc-600 hover:text-zinc-950 transition-colors duration-150">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @php
                            $cartCount = 0;
                            $cart = session()->get('cart', []);
                            foreach ($cart as $item) {
                                $cartCount += $item['quantity'];
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-zinc-950 text-white text-[10px] font-black rounded-full h-5 w-5 flex items-center justify-center border-2 border-white animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Mobile Menu Button -->
                    <button @click="open = !open" class="md:hidden text-zinc-600 hover:text-zinc-950 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu Backdrop -->
        <div x-show="open" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-20 left-0 w-full bottom-0 bg-zinc-950/60 z-40 md:hidden" 
             @click="open = false"
             x-cloak></div>

        <!-- Mobile Navigation Menu Panel -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="-translate-y-full"
             class="absolute top-full left-0 w-full bg-white border-t border-gray-200 shadow-xl z-50 md:hidden flex flex-col" 
             x-cloak>
            <div class="px-4 py-4 space-y-2 overflow-y-auto max-h-[70vh]">
                <a href="{{ route('catalog') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">SHOP ALL</a>
                <a href="{{ route('catalog', ['category' => 'pallets']) }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">PALLETS</a>
                <a href="{{ route('catalog', ['category' => 'truckloads']) }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">TRUCKLOADS</a>
                <a href="{{ route('how-it-works') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">HOW IT WORKS</a>
                <a href="{{ route('sell-to-us') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">SELL TO US</a>
                <a href="{{ route('faq') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">FAQ</a>
                <a href="{{ route('contact') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">CONTACT</a>
                
                <hr class="border-gray-200 my-2">
                
                @auth
                    <div class="px-3 py-2">
                        <span class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Account</span>
                    </div>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 transition-colors">Admin Panel</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 transition-colors">My Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 transition-colors">Profile Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-3 rounded-md text-base font-bold text-red-600 hover:bg-gray-100 transition-colors">Sign Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-3 rounded-md text-base font-bold text-zinc-800 hover:bg-gray-100 hover:text-zinc-950 transition-colors">SIGN IN</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Email Alerts Subscription Bar -->
    <section class="bg-zinc-950 text-white py-12 px-4 border-t border-zinc-800">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2 uppercase">Never Miss a Liquidated Deal</h3>
            <p class="text-zinc-400 text-sm sm:text-base mb-6 max-w-xl mx-auto">Get instant email notifications the moment new high-demand pallets and retail truckloads arrive at our warehouse.</p>
            
            @if(session('subscribed'))
                <div class="bg-emerald-500/10 border border-emerald-500 text-emerald-400 p-4 rounded-md font-bold mb-4">
                    {{ session('subscribed') }}
                </div>
            @else
                <form action="{{ route('subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-2 max-w-md mx-auto">
                    @csrf
                    <input type="email" name="email" required placeholder="Enter your email address" class="bg-zinc-900 border border-zinc-800 text-white rounded px-4 py-3 text-sm focus:outline-none focus:border-zinc-500 flex-grow" />
                    <button type="submit" class="bg-white text-zinc-950 font-bold px-6 py-3 rounded text-sm uppercase tracking-wider hover:bg-zinc-200 transition duration-150">Subscribe</button>
                </form>
                @error('email')
                    <p class="text-rose-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                @enderror
            @endif
        </div>
    </section>

    <!-- Footer Area -->
    <footer class="bg-zinc-950 text-zinc-400 border-t border-zinc-900 py-16 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 sm:gap-8 mb-12">
            
            <!-- Column 1: Brand details -->
            <div class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <span class="bg-white text-zinc-950 px-3 py-1.5 rounded font-black text-xl tracking-tight shadow">APL</span>
                    <span class="text-white font-extrabold text-lg tracking-tight">AMERICAN PALLET</span>
                </a>
                <p class="text-xs leading-relaxed text-zinc-500">America's premier high-volume wholesale liquidation supplier. Providing resellers, store owners, and discount merchants with unmatched return loads, overstock pallets, and bulk liquidations.</p>
                <div class="text-xs text-zinc-500 font-semibold">
                    <span>Warehouse Address:</span>
                    <address class="not-italic text-zinc-400 mt-1">APL Warehouse, Louisville, KY</address>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('catalog') }}" class="hover:text-white transition">Shop All Merchandise</a></li>
                    <li><a href="{{ route('catalog', ['category' => 'pallets']) }}" class="hover:text-white transition">Liquidation Pallets</a></li>
                    <li><a href="{{ route('catalog', ['category' => 'truckloads']) }}" class="hover:text-white transition">Retail Store Truckloads</a></li>
                    <li><a href="{{ route('sell-to-us') }}" class="hover:text-white transition">Sell Excess Stock to Us</a></li>
                </ul>
            </div>

            <!-- Column 3: Customer Care -->
            <div>
                <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-4">Customer Care</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('how-it-works') }}" class="hover:text-white transition">How To Purchase</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition">Frequently Asked Questions</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact Support</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Merchant Account</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact Information -->
            <div>
                <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-4">Contact Information</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:5022081035" class="text-zinc-300 hover:text-white transition">(502) 208-1035</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:Brett@bidonpallets.com" class="text-zinc-300 hover:text-white transition">Brett@bidonpallets.com</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto border-t border-zinc-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Copyright -->
            <p class="text-xs text-zinc-600">&copy; {{ date('Y') }} American Pallet Liquidators. All Rights Reserved. Built for Design Study.</p>
            
            <!-- Payment Icons Grid -->
            <div class="flex flex-wrap justify-center gap-2">
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="Stripe Cards">Stripe Elements</span>
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="Zelle">Zelle</span>
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="Cash App">Cash App</span>
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="Venmo">Venmo</span>
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="USDT">USDT (Crypto)</span>
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="Bank Wire">Bank Wire</span>
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="PayPal">PayPal</span>
                <span class="bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500 font-bold px-2 py-1 rounded" title="Cash on Pickup">Cash pickup</span>
            </div>
        </div>
    </footer>

</body>
</html>
