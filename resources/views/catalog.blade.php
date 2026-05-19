@extends('layouts.ecommerce')

@section('title', 'Shop Wholesale Liquidation Pallets & Truckloads')

@section('content')
    <!-- Catalog Header -->
    <section class="bg-white border-b border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-zinc-950 uppercase tracking-tight mb-2">Wholesale Catalog</h1>
            <p class="text-slate-500 text-sm sm:text-base">Browse direct liquidated inventory. Real-time availability on high-piece-count lots.</p>
        </div>
    </section>

    <!-- Catalog Content -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Filters Sidebar (Desktop) -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <form action="{{ route('catalog') }}" method="GET" class="space-y-8 bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-3">Search Products</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Keyword..." class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @if(request('search'))
                                <a href="{{ route('catalog', request()->except('search')) }}" class="absolute right-2 top-2 text-gray-400 hover:text-zinc-950">&times;</a>
                            @endif
                        </div>
                    </div>

                    <!-- Categories Filter -->
                    <div>
                        <span class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-3">Categories</span>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-zinc-700 hover:text-zinc-950 cursor-pointer">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="text-zinc-900 focus:ring-zinc-900 border-gray-300" />
                                <span>All Merchandise</span>
                            </label>
                            @foreach($categories as $cat)
                                <label class="flex items-center gap-2 text-sm font-semibold text-zinc-700 hover:text-zinc-950 cursor-pointer">
                                    <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="text-zinc-900 focus:ring-zinc-900 border-gray-300" />
                                    <span>{{ $cat->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sorting -->
                    <div>
                        <label for="sort" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-3">Sort By</label>
                        <select id="sort" name="sort" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-semibold">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-2.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150">
                        Apply Filters
                    </button>
                    
                    @if(request()->anyFilled(['search', 'category', 'sort']))
                        <a href="{{ route('catalog') }}" class="block text-center text-xs font-bold text-zinc-500 hover:text-zinc-900 transition mt-2">
                            Reset All Filters
                        </a>
                    @endif
                </form>
            </aside>

            <!-- Product Grid & Pagination -->
            <div class="flex-grow">
                
                <!-- Info bar -->
                <div class="flex justify-between items-center mb-6 bg-white border border-gray-200 rounded-lg px-6 py-4 shadow-sm text-sm">
                    <span class="font-semibold text-slate-500">Showing <span class="text-zinc-950 font-bold">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> of <span class="text-zinc-950 font-bold">{{ $products->total() }}</span> results</span>
                    <span class="hidden sm:inline font-semibold text-slate-500">Louisville, KY Direct Contract Loads</span>
                </div>

                @if($products->count() === 0)
                    <div class="bg-white border border-gray-200 rounded-lg p-16 text-center shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-zinc-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="text-lg font-extrabold text-zinc-900 uppercase tracking-tight mb-2">No merchandise matches your criteria</h3>
                        <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">Try clearing your active search filters or browsing other categories.</p>
                        <a href="{{ route('catalog') }}" class="bg-zinc-950 text-white font-extrabold px-6 py-3 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition shadow">Reset Filters</a>
                    </div>
                @else
                    <!-- Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                        @foreach($products as $product)
                            <div class="group relative bg-white flex flex-col h-full border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                                
                                <!-- Badges & Image Container -->
                                <div class="relative aspect-square bg-gray-50 flex items-center justify-center p-4 overflow-hidden border-b border-gray-100">
                                    @if($product->badge == 'sold_out')
                                        <span class="absolute top-3 left-3 bg-zinc-950 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded z-10">Sold Out</span>
                                    @elseif($product->badge == 'sale')
                                        <span class="absolute top-3 left-3 bg-red-600 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded z-10 shadow">On Sale</span>
                                    @endif

                                    <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="object-cover max-h-full max-w-full group-hover:scale-105 transition-transform duration-300" />

                                    <!-- Hover Overlay -->
                                    <a href="{{ route('products.show', $product->slug) }}" class="absolute inset-0 z-20 flex items-center justify-center bg-zinc-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <span class="bg-white text-zinc-950 font-extrabold text-xs uppercase tracking-wider px-5 py-2.5 rounded shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300">View Details</span>
                                    </a>
                                </div>

                                <!-- Product Content -->
                                <div class="p-6 flex-grow flex flex-col justify-between">
                                    <div>
                                        <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest block mb-1.5">{{ $product->category->name }}</span>
                                        <h3 class="text-base font-extrabold text-zinc-900 uppercase tracking-tight group-hover:text-zinc-600 transition leading-tight mb-2.5">
                                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                        </h3>
                                        <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed mb-4">{{ Str::limit($product->description, 100) }}</p>
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

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
