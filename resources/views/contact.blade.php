@extends('layouts.ecommerce')

@section('title', 'Contact American Pallet Liquidators')

@section('content')
    <!-- Header -->
    <section class="bg-white border-b border-gray-200 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Merchant Center</span>
            <h1 class="text-3xl sm:text-5xl font-black text-zinc-950 uppercase tracking-tight mb-4">Contact Our Warehouse</h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">Reach out to purchase liquidation pallets, schedule warehouse cargo pickups, or request a freight shipping quote.</p>
        </div>
    </section>

    <!-- Content Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- Left Column: Contact details & Map -->
            <div class="space-y-8 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                <div>
                    <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-4">Warehouse Contact Details</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <span class="bg-zinc-100 text-zinc-900 p-2.5 rounded shadow-sm">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div>
                                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400">Phone Call / SMS Support</span>
                                <a href="tel:+447882769759" class="text-zinc-950 font-extrabold text-lg sm:text-xl hover:underline">+44 7882 769759</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="bg-zinc-100 text-zinc-900 p-2.5 rounded shadow-sm">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <div>
                                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400">General &amp; Sales Email</span>
                                <a href="mailto:americanpalletliquidators0@gmail.com" class="text-zinc-950 font-extrabold text-lg sm:text-xl hover:underline">americanpalletliquidators0@gmail.com</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="bg-zinc-100 text-zinc-900 p-2.5 rounded shadow-sm">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400">Louisville Warehouse Facility</span>
                                <address class="not-italic text-zinc-950 font-extrabold text-lg leading-snug">
                                    American Pallet Liquidators<br>Louisville, KY
                                </address>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Open Hours -->
                <div class="pt-6 border-t border-gray-100">
                    <span class="block text-xs font-black uppercase tracking-wider text-zinc-400 mb-2">Hours of Operation</span>
                    <p class="text-sm font-semibold text-zinc-800">Monday - Friday: 9:00 AM - 5:00 PM EST</p>
                    <p class="text-sm text-slate-500">Saturday &amp; Sunday: Closed (Loading dock pickup by pre-approved appointment only)</p>
                </div>

                <!-- Google Maps Placeholder -->
                <div class="aspect-[16/9] w-full bg-gray-100 border border-gray-200 rounded overflow-hidden relative">
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                        <svg class="h-10 w-10 text-zinc-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm">Interactive Warehouse Map</span>
                        <span class="text-xs text-zinc-400 mt-1">APL Direct Dock &amp; Warehouse — Louisville, KY</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact form -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-4">Send Us A Message</h2>
                <p class="text-slate-500 text-sm mb-6">Have questions or want to purchase? Fill in the form below and our wholesale representatives will reach out immediately.</p>

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Email Address</label>
                            <input type="email" id="email" name="email" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('email') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Phone Number</label>
                            <input type="text" id="phone" name="phone" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('phone') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Your Message / Inquiry</label>
                        <textarea id="message" name="message" rows="5" required placeholder="Describe the pallets or truckloads you are interested in..." class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800"></textarea>
                        @error('message') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                        Submit Inquiry
                    </button>
                </form>
            </div>

        </div>
    </section>
@endsection
