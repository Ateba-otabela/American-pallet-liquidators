@extends('layouts.ecommerce')

@section('title', 'America\'s Most Trusted Supplier of Liquidated Merchandise')

@section('content')
    <style>
        @keyframes slowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.15); }
        }
        .animate-slow-zoom {
            animation: slowZoom 30s ease-in-out infinite alternate;
        }
    </style>
    
    <!-- Hero Section -->
    <section class="relative border-b border-gray-200 overflow-hidden flex items-center justify-center min-h-[80vh]">
        
        <!-- Animated Background Image -->
        <div class="absolute inset-0 z-0 overflow-hidden bg-zinc-950">
            <img src="/images/products/Screenshot (283).png" alt="Pallet Shop Interior" class="w-full h-full object-cover animate-slow-zoom opacity-50" />
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 relative z-10 flex flex-col items-center text-center">
            <span class="text-zinc-300 text-xs sm:text-sm font-extrabold uppercase tracking-widest mb-4 block">Direct Liquidation Warehouse</span>
            
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white max-w-4xl uppercase leading-tight mb-6 drop-shadow-md">
                America's Most Trusted Supplier of <span class="text-blue-500 block sm:inline">Liquidated Merchandise</span>
            </h1>
            
            <p class="text-zinc-300 text-base sm:text-xl max-w-2xl leading-relaxed mb-10 drop-shadow">
                Direct-from-source liquidation pallets and department store truckloads. Untouched merchandise, shelf pulls, and high-margin overstocks for retail stores, flea markets, and bin stores.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                <a href="{{ route('catalog') }}" class="bg-white text-zinc-950 font-extrabold px-8 py-4 rounded text-sm sm:text-base uppercase tracking-wider hover:bg-gray-100 transition duration-150 shadow-lg">
                    Shop All Merchandise
                </a>
                <a href="{{ route('how-it-works') }}" class="bg-transparent border border-zinc-500 text-white font-extrabold px-8 py-4 rounded text-sm sm:text-base uppercase tracking-wider hover:border-white hover:bg-white/10 transition duration-150 shadow-sm">
                    How To Purchase
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="bg-gray-100 border-b border-gray-200 py-10 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <span class="block text-3xl sm:text-4xl font-extrabold text-zinc-950 tracking-tight">20,000+</span>
                <span class="text-xs sm:text-sm font-bold text-zinc-500 uppercase tracking-widest mt-1 block">Pallets Sold</span>
            </div>
            <div>
                <span class="block text-3xl sm:text-4xl font-extrabold text-zinc-950 tracking-tight">10+ Years</span>
                <span class="text-xs sm:text-sm font-bold text-zinc-500 uppercase tracking-widest mt-1 block">In Business</span>
            </div>
            <div>
                <span class="block text-3xl sm:text-4xl font-extrabold text-zinc-950 tracking-tight">5-Star</span>
                <span class="text-xs sm:text-sm font-bold text-zinc-500 uppercase tracking-widest mt-1 block">Merchant Rating</span>
            </div>
            <div>
                <span class="block text-3xl sm:text-4xl font-extrabold text-zinc-950 tracking-tight">Direct</span>
                <span class="text-xs sm:text-sm font-bold text-zinc-500 uppercase tracking-widest mt-1 block">Contract Pricing</span>
            </div>
        </div>
    </section>

    <!-- Category Banner Cards -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Pallets Card -->
            <a href="{{ route('catalog', ['category' => 'pallets']) }}" class="group relative bg-white border border-gray-200 rounded-lg p-10 flex flex-col justify-between overflow-hidden shadow-sm hover:shadow-md hover:border-gray-300 transition duration-200 min-h-[320px]">
                <div class="relative z-10">
                    <span class="bg-zinc-100 text-zinc-800 text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded inline-block mb-4">By the Pallet</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-950 uppercase tracking-tight mb-2">Liquidation Pallets</h2>
                    <p class="text-slate-500 text-sm max-w-sm leading-relaxed">Untouched pharmacy HBA, high count Amazon pallets, apparel, electronics, and mixed general merchandise. Pick up in Louisville or ship nationwide.</p>
                </div>
                <div class="flex items-center gap-2 font-bold text-zinc-950 uppercase tracking-wider text-xs relative z-10 group-hover:text-zinc-600 transition mt-6">
                    <span>Explore Pallets</span>
                    <svg class="h-4 w-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
                <!-- Graphic overlay -->
                <div class="absolute right-0 bottom-0 opacity-5 group-hover:opacity-10 transition duration-300 transform translate-x-6 translate-y-6">
                    <svg class="w-64 h-64 text-zinc-950" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h18v18H3V3zm2 2v14h14V5H5z"/></svg>
                </div>
            </a>

            <!-- Truckloads Card -->
            <a href="{{ route('catalog', ['category' => 'truckloads']) }}" class="group relative bg-white border border-gray-200 rounded-lg p-10 flex flex-col justify-between overflow-hidden shadow-sm hover:shadow-md hover:border-gray-300 transition duration-200 min-h-[320px]">
                <div class="relative z-10">
                    <span class="bg-zinc-100 text-zinc-800 text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded inline-block mb-4">By the Truckload</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-950 uppercase tracking-tight mb-2">Retail Store Truckloads</h2>
                    <p class="text-slate-500 text-sm max-w-sm leading-relaxed">High piece count department store return loads, case pack general merchandise, bedding, furniture, and lost mail truckloads. Massive margins!</p>
                </div>
                <div class="flex items-center gap-2 font-bold text-zinc-950 uppercase tracking-wider text-xs relative z-10 group-hover:text-zinc-600 transition mt-6">
                    <span>Explore Truckloads</span>
                    <svg class="h-4 w-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
                <!-- Graphic overlay -->
                <div class="absolute right-0 bottom-0 opacity-5 group-hover:opacity-10 transition duration-300 transform translate-x-6 translate-y-6">
                    <svg class="w-64 h-64 text-zinc-950" fill="currentColor" viewBox="0 0 24 24"><path d="M17 16a3 3 0 11-6 0 3 3 0 016 0zM5 11h14v2H5v-2z"/></svg>
                </div>
            </a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="bg-white border-t border-b border-gray-200 py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-12">
                <div>
                    <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-1">Weekly Arrivals</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-zinc-950 uppercase tracking-tight">Featured Liquidation Lots</h2>
                </div>
                <a href="{{ route('catalog') }}" class="text-xs sm:text-sm font-bold text-zinc-900 uppercase tracking-wider border-b-2 border-zinc-900 pb-0.5 hover:text-zinc-500 hover:border-zinc-300 transition mt-4 sm:mt-0">
                    View All Inventory
                </a>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                    <div class="group relative bg-white flex flex-col h-full border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                        
                        <!-- Badges & Image Container -->
                        <div class="relative aspect-square bg-gray-50 flex items-center justify-center p-4 overflow-hidden border-b border-gray-100">
                            @if($product->badge == 'sold_out')
                                <span class="absolute top-3 left-3 bg-zinc-950 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded z-10">Sold Out</span>
                            @elseif($product->badge == 'sale')
                                <span class="absolute top-3 left-3 bg-red-600 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded z-10 shadow">On Sale</span>
                            @endif

                            <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="object-cover max-h-full max-w-full group-hover:scale-105 transition-transform duration-300" />

                            <!-- Hover Overlay with quick view link -->
                            <a href="{{ route('products.show', $product->slug) }}" class="absolute inset-0 z-20 flex items-center justify-center bg-zinc-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <span class="bg-white text-zinc-950 font-extrabold text-xs uppercase tracking-wider px-5 py-2.5 rounded shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300">View Details</span>
                            </a>
                        </div>

                        <!-- Product Content Info -->
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest block mb-1.5">{{ $product->category->name }}</span>
                                <h3 class="text-base font-extrabold text-zinc-900 uppercase tracking-tight group-hover:text-zinc-600 transition leading-tight mb-2.5">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                            </div>
                            
                            <div class="flex items-center gap-2.5 mt-auto pt-4 border-t border-gray-100">
                                @if($product->original_price)
                                    <span class="text-sm text-zinc-400 line-through">${{ number_format($product->original_price) }}</span>
                                    <span class="text-lg font-black text-red-600">${{ number_format($product->price) }}</span>
                                @else
                                    <span class="text-lg font-black text-zinc-950">${{ number_format($product->price) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Buy From Us Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Our Advantage</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-zinc-950 uppercase tracking-tight mb-4">Direct Contracts, Absolute Trust</h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Unlike brokers who tack on heavy markups and middleman fees, we buy our liquidation inventory directly from retail giants, fulfillment networks, and national drug store chains. This ensures you get the lowest wholesale rates on the market.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Point 1 -->
            <div class="bg-white p-8 rounded-lg border border-gray-200 shadow-sm flex gap-5">
                <span class="text-zinc-300 font-black text-5xl leading-none">01</span>
                <div>
                    <h3 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight mb-2">Fully Untouched</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Our liquidation pallets are fully untouched and unsearched. What we receive is exactly what you get — maximizing your chances of high-value items.</p>
                </div>
            </div>

            <!-- Point 2 -->
            <div class="bg-white p-8 rounded-lg border border-gray-200 shadow-sm flex gap-5">
                <span class="text-zinc-300 font-black text-5xl leading-none">02</span>
                <div>
                    <h3 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight mb-2">Louisville Pickup</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Resellers are welcome to visit our Louisville, KY warehouse, view available stock in person, pay, and load their own trucks with no hidden pickup charges.</p>
                </div>
            </div>

            <!-- Point 3 -->
            <div class="bg-white p-8 rounded-lg border border-gray-200 shadow-sm flex gap-5">
                <span class="text-zinc-300 font-black text-5xl leading-none">03</span>
                <div>
                    <h3 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight mb-2">8 Payment Methods</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">We support credit cards (Stripe), Bank Wire, Cash App, Venmo, PayPal, Zelle, USDT, and Cash on Pickup, enabling fast checkout for merchants of all scales.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
