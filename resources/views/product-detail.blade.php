@extends('layouts.ecommerce')

@section('title', $product->name)
@section('meta_description', Str::limit($product->description, 160))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-xs font-bold uppercase tracking-wider text-zinc-400 mb-8 gap-2">
            <a href="{{ route('home') }}" class="hover:text-zinc-950 transition">Home</a>
            <span>/</span>
            <a href="{{ route('catalog') }}" class="hover:text-zinc-950 transition">Catalog</a>
            <span>/</span>
            <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="hover:text-zinc-950 transition">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-zinc-600 truncate">{{ $product->name }}</span>
        </nav>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md font-semibold mb-6 text-sm flex items-center gap-2">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Main Product Block -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-white border border-gray-200 rounded-xl p-6 sm:p-8 shadow-sm">
            
            <!-- Left Column: Product Image -->
            <div class="flex flex-col space-y-4">
                <div class="relative aspect-square bg-gray-50 border border-gray-200 rounded-lg overflow-hidden flex items-center justify-center p-8">
                    @if($product->badge == 'sold_out')
                        <span class="absolute top-4 left-4 bg-zinc-950 text-white text-xs font-black uppercase tracking-widest px-3 py-1.5 rounded z-10">Sold Out</span>
                    @elseif($product->badge == 'sale')
                        <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black uppercase tracking-widest px-3 py-1.5 rounded z-10 shadow">On Sale</span>
                    @endif

                    <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="object-cover max-h-full max-w-full" />
                </div>
            </div>

            <!-- Right Column: Product Actions & Description -->
            <div class="flex flex-col justify-between">
                
                <!-- Brand & Title -->
                <div>
                    <span class="text-zinc-400 text-xs font-extrabold uppercase tracking-widest block mb-2">{{ $product->category->name }}</span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-zinc-950 uppercase tracking-tight mb-4 leading-tight">{{ $product->name }}</h1>
                    
                    <!-- Price block -->
                    <div class="flex items-center gap-4 py-4 border-t border-b border-gray-100 mb-6">
                        @if($product->original_price)
                            <span class="text-lg text-zinc-400 line-through">${{ number_format($product->original_price, 2) }}</span>
                            <span class="text-3xl font-black text-red-600">${{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="text-3xl font-black text-zinc-950">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Stock, Cart and Action Form -->
                <div class="space-y-6">
                    
                    <!-- Stock Alert -->
                    @if($product->badge == 'sold_out' || $product->stock <= 0)
                        <div class="bg-zinc-100 text-zinc-600 font-bold px-4 py-3 rounded text-sm uppercase tracking-wide inline-block">
                            SOLD OUT — Next batch arriving soon
                        </div>
                    @else
                        @if($product->stock <= 3)
                            <p class="text-amber-600 text-xs font-extrabold uppercase tracking-wider animate-pulse flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                ONLY {{ $product->stock }} LEFT IN STOCK — High demand!
                            </p>
                        @else
                            <p class="text-emerald-600 text-xs font-extrabold uppercase tracking-wider flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                IN STOCK — Ready for shipping or pickup
                            </p>
                        @endif

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-col sm:flex-row gap-3 pt-2">
                            @csrf
                            <!-- Quantity Selector -->
                            <div class="flex border border-gray-300 rounded overflow-hidden max-w-[140px]" x-data="{ qty: 1 }">
                                <button type="button" @click="if (qty > 1) qty--" class="bg-gray-50 text-zinc-600 hover:bg-gray-100 px-3 py-2 text-sm font-black focus:outline-none">-</button>
                                <input type="number" name="quantity" x-model="qty" readonly class="w-full text-center border-0 bg-white font-bold text-sm text-zinc-800 focus:ring-0 p-0" />
                                <button type="button" @click="if (qty < {{ $product->stock }}) qty++" class="bg-gray-50 text-zinc-600 hover:bg-gray-100 px-3 py-2 text-sm font-black focus:outline-none">+</button>
                            </div>

                            <!-- Add Button -->
                            <button type="submit" class="flex-grow bg-zinc-950 text-white font-extrabold py-3 px-8 rounded text-sm uppercase tracking-wider hover:bg-zinc-800 transition duration-150 shadow-md">
                                Add to Cart
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Condition & Buying Warning Notices -->
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-md mt-8">
                    <span class="block text-amber-800 text-xs font-black uppercase tracking-wider mb-1">Condition & Policy Notice</span>
                    <p class="text-amber-700 text-xs leading-relaxed">
                        This merchandise consists of raw, untouched wholesale liquidations and retail returns. All lots are sold <strong>AS-IS / WHERE-IS</strong> with no guarantees, returns, or refunds. Please read our <a href="{{ route('faq') }}" class="underline font-bold">FAQ</a> before completing your purchase.
                    </p>
                </div>

                <!-- Tabbed specifications -->
                <div class="mt-8 pt-8 border-t border-gray-100" x-data="{ tab: 'description' }">
                    <div class="flex border-b border-gray-200 text-xs font-black uppercase tracking-wider">
                        <button @click="tab = 'description'" :class="tab == 'description' ? 'border-zinc-950 text-zinc-950' : 'border-transparent text-zinc-400 hover:text-zinc-700'" class="pb-3 border-b-2 px-4 focus:outline-none">Description</button>
                        <button @click="tab = 'shipping'" :class="tab == 'shipping' ? 'border-zinc-950 text-zinc-950' : 'border-transparent text-zinc-400 hover:text-zinc-700'" class="pb-3 border-b-2 px-4 focus:outline-none">Shipping & Pickup</button>
                        <button @click="tab = 'payment'" :class="tab == 'payment' ? 'border-zinc-950 text-zinc-950' : 'border-transparent text-zinc-400 hover:text-zinc-700'" class="pb-3 border-b-2 px-4 focus:outline-none">Payment Info</button>
                    </div>

                    <div class="py-6 text-sm text-slate-600 leading-relaxed">
                        <div x-show="tab == 'description'">
                            <p class="whitespace-pre-line">{{ $product->description }}</p>
                        </div>
                        <div x-show="tab == 'shipping'" x-cloak class="space-y-3">
                            <p><strong>Louisville Warehouse Pickup:</strong> Free of charge. Select "Cash on Pickup" or complete payment online and contact us to schedule your loading dock time. Forklift loading is provided free.</p>
                            <p><strong>Freight Shipping:</strong> We arrange LTL and full truckload carrier shipments nationwide. Freight shipping costs are billed separately after checkout based on carrier rates to your zip code.</p>
                        </div>
                        <div x-show="tab == 'payment'" x-cloak class="space-y-3">
                            <p>We process payments securely via 8 options:</p>
                            <ul class="list-disc pl-5 space-y-1 text-xs font-semibold text-zinc-700">
                                <li>Secure Card Checkout (Stripe Elements)</li>
                                <li>Bank Wire Transfer (Chase Bank)</li>
                                <li>Cash App, Venmo, PayPal</li>
                                <li>Zelle Business Pay</li>
                                <li>USDT (TRC-20 / ERC-20 Cryptocurrency)</li>
                                <li>Cash on Pickup (Louisville Warehouse)</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->count() > 0)
            <div class="mt-20">
                <h2 class="text-2xl font-extrabold text-zinc-950 uppercase tracking-tight mb-8">Related Liquidation Lots</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($relatedProducts as $rel)
                        <div class="group relative bg-white flex flex-col h-full border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                            
                            <div class="relative aspect-square bg-gray-50 flex items-center justify-center p-4 overflow-hidden border-b border-gray-100">
                                @if($rel->badge == 'sold_out')
                                    <span class="absolute top-3 left-3 bg-zinc-950 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded z-10">Sold Out</span>
                                @elseif($rel->badge == 'sale')
                                    <span class="absolute top-3 left-3 bg-red-600 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded z-10 shadow">On Sale</span>
                                @endif

                                <img src="{{ $rel->first_image_url }}" alt="{{ $rel->name }}" class="object-cover max-h-full max-w-full group-hover:scale-105 transition-transform duration-300" />
                                
                                <a href="{{ route('products.show', $rel->slug) }}" class="absolute inset-0 z-20 flex items-center justify-center bg-zinc-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <span class="bg-white text-zinc-950 font-extrabold text-xs uppercase tracking-wider px-5 py-2.5 rounded shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300">View Details</span>
                                </a>
                            </div>

                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <h3 class="text-sm font-extrabold text-zinc-900 uppercase tracking-tight group-hover:text-zinc-600 transition leading-tight mb-2">
                                    <a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h3>
                                
                                <div class="flex items-center gap-2 mt-auto pt-4 border-t border-gray-100">
                                    @if($rel->original_price)
                                        <span class="text-xs text-zinc-400 line-through">${{ number_format($rel->original_price) }}</span>
                                        <span class="text-base font-black text-red-600">${{ number_format($rel->price) }}</span>
                                    @else
                                        <span class="text-base font-black text-zinc-950">${{ number_format($rel->price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
