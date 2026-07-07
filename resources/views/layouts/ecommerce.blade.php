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
        <a href="tel:+447882769759" class="underline hover:text-zinc-300 transition duration-150">+44 7882 769759</a>
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
                        <div class="hidden sm:flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-sm font-semibold tracking-wide text-zinc-600 hover:text-zinc-950 transition duration-150">SIGN IN</a>
                        </div>
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
                        <a href="tel:+447882769759" class="text-zinc-300 hover:text-white transition">+44 7882 769759</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:americanpalletliquidators0@gmail.com" class="text-zinc-300 hover:text-white transition">americanpalletliquidators0@gmail.com</a>
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

    <!-- AI Customer Support Chat Widget -->
    <div x-data="chatWidget()" x-init="initChat()" class="fixed bottom-6 right-6 z-50 font-sans">
        <!-- Chat Button -->
        <button @click="toggleChat()" x-show="!isOpen" x-transition class="bg-zinc-950 text-white p-4 rounded-full shadow-2xl hover:scale-105 transition-transform flex items-center justify-center focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        </button>

        <!-- Chat Window -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-10 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-10 scale-95" class="bg-white w-full sm:w-96 rounded-2xl shadow-2xl overflow-hidden flex flex-col border border-gray-200 fixed sm:absolute bottom-0 sm:bottom-0 right-0 sm:right-0 top-0 sm:top-auto sm:h-[600px] max-h-screen z-50" x-cloak>
            
            <!-- Header -->
            <div class="bg-zinc-950 text-white p-4 flex justify-between items-center shadow-md z-10 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-zinc-800 rounded-full flex items-center justify-center border border-zinc-700">
                        <span class="font-black text-xs uppercase">APL</span>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm uppercase tracking-tight">Support Specialist</h4>
                        <p class="text-[10px] text-zinc-400 font-bold flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Online</span>
                        </p>
                    </div>
                </div>
                <button @click="toggleChat()" class="text-zinc-400 hover:text-white transition focus:outline-none p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Messages Area -->
            <div id="chatMessagesArea" class="flex-grow p-4 overflow-y-auto bg-gray-50 flex flex-col gap-4">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex w-full" :class="msg.sender_type === 'customer' ? 'justify-end' : 'justify-start'">
                        <div class="max-w-[85%] rounded-2xl p-3 shadow-sm relative text-sm"
                             :class="msg.sender_type === 'customer' ? 'bg-zinc-950 text-white rounded-tr-sm' : 'bg-white border border-gray-200 text-zinc-800 rounded-tl-sm'">
                            
                            <template x-if="msg.sender_type === 'ai' || msg.sender_type === 'admin'">
                                <span class="text-[9px] text-blue-600 font-extrabold block mb-1 uppercase tracking-wider">Support Specialist</span>
                            </template>

                            <div x-html="msg.message.replace(/\n/g, '<br>')"></div>
                            
                            <div class="flex items-center justify-end gap-1 mt-1 text-[9px] opacity-70">
                                <span x-text="new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                                <template x-if="msg.sender_type === 'customer' && msg.is_seen">
                                    <svg class="w-3 h-3 text-emerald-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
                
                <div x-show="isTyping" class="flex justify-start">
                    <div class="bg-white border border-gray-200 text-zinc-800 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm w-16 flex items-center justify-center gap-1">
                        <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-3 bg-white border-t border-gray-200 shrink-0">
                <form @submit.prevent="sendMessage" class="flex items-end gap-2 relative">
                    <div class="flex-grow bg-gray-50 border border-gray-300 rounded-xl flex items-center px-2 py-1 focus-within:border-zinc-500 focus-within:ring-1 focus-within:ring-zinc-500 transition-shadow">
                        <!-- Attachment Button (Stub) -->
                        <button type="button" class="p-2 text-zinc-400 hover:text-zinc-600 transition focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        </button>
                        
                        <textarea x-model="newMessage" @keydown.enter.prevent="sendMessage" @input="resizeInput($event.target)" rows="1" placeholder="Type your message..." class="flex-grow bg-transparent border-none text-sm px-2 py-2 focus:ring-0 resize-none max-h-32 text-zinc-800"></textarea>
                        
                        <!-- Emoji Button (Stub) -->
                        <button type="button" class="p-2 text-zinc-400 hover:text-zinc-600 transition focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </button>
                    </div>
                    
                    <button type="submit" :disabled="!newMessage.trim() || sending" class="bg-zinc-950 text-white p-3 rounded-xl hover:bg-zinc-800 transition disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none flex-shrink-0">
                        <svg x-show="!sending" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <svg x-show="sending" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function chatWidget() {
            return {
                isOpen: false,
                sessionId: null,
                messages: [],
                newMessage: '',
                sending: false,
                isTyping: false,
                aiActive: true,

                initChat() {
                    // Try to init conversation with backend
                    fetch('{{ route('chat.init') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.sessionId = data.session_id;
                        this.messages = data.conversation.messages || [];
                        this.aiActive = data.conversation.ai_active;
                        
                        // If no messages exist yet, add a friendly AI greeting
                        if (this.messages.length === 0) {
                            this.messages.push({
                                id: 'welcome',
                                sender_type: 'ai',
                                message: "Hello! Welcome to American Pallet Liquidators. How can I help you today? Ask me about our liquidation pallets, warehouse locations, shipping rates, or return policies!",
                                created_at: new Date().toISOString(),
                                is_seen: true
                            });
                        }
                        
                        this.scrollToBottom();
                        
                        // Setup Echo Listeners if Echo is available
                        if (window.Echo) {
                            window.Echo.channel('chat.' + this.sessionId)
                                .listen('MessageSent', (e) => {
                                    const exists = this.messages.some(msg => msg.id === e.message.id);
                                    if (!exists) {
                                        this.messages.push(e.message);
                                        this.scrollToBottom();
                                    }
                                    this.isTyping = false;
                                })
                                .listen('ConversationUpdated', (e) => {
                                    this.aiActive = e.conversation.ai_active;
                                });
                        }
                    });
                },

                toggleChat() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen) {
                        setTimeout(() => this.scrollToBottom(), 100);
                    }
                },

                sendMessage() {
                    if (!this.newMessage.trim() || this.sending) return;

                    const msgText = this.newMessage;
                    this.newMessage = '';
                    this.sending = true;
                    
                    // Optimistic update
                    const tempId = Date.now();
                    this.messages.push({
                        id: tempId,
                        sender_type: 'customer',
                        message: msgText,
                        created_at: new Date().toISOString(),
                        is_seen: false
                    });
                    
                    this.scrollToBottom();
                    this.isTyping = true; // Show typing indicator while waiting for AI

                    fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            session_id: this.sessionId,
                            message: msgText,
                            page_url: window.location.href,
                            page_title: document.title
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.sending = false;
                        this.isTyping = false;
                        
                        // Handle direct JSON reply/handover response (when Echo isn't running)
                        if (data.status === 'replied' || data.status === 'handover') {
                            const exists = this.messages.some(msg => msg.id === data.message.id);
                            if (!exists) {
                                // If the optimistic message is still there, we keep it, and add the AI's response
                                this.messages.push(data.message);
                                this.scrollToBottom();
                            }
                        } else if (data.status === 'waiting') {
                            this.aiActive = false;
                        }
                    })
                    .catch(() => {
                        this.sending = false;
                        this.isTyping = false;
                    });
                },

                scrollToBottom() {
                    setTimeout(() => {
                        const container = document.getElementById('chatMessagesArea');
                        if (container) container.scrollTop = container.scrollHeight;
                    }, 50);
                },

                resizeInput(el) {
                    el.style.height = 'auto';
                    el.style.height = (el.scrollHeight < 120 ? el.scrollHeight : 120) + 'px';
                }
            }
        }
    </script>

</body>
</html>
