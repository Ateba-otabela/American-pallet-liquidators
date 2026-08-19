@extends('layouts.ecommerce')

@section('title', 'Request a Freight Shipping Quote — APL Pallets')

@section('content')
    <!-- Header -->
    <section class="bg-white border-b border-gray-200 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Logistics Center</span>
            <h1 class="text-3xl sm:text-5xl font-black text-zinc-950 uppercase tracking-tight mb-4">Request a Freight Quote</h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                Need shipping? We arrange LTL and full truckload transit nationwide through our carrier network to secure the lowest shipping rates for your wholesale pallets or truckloads.
            </p>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
            <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-4">Shipping & Delivery Details</h2>
            <p class="text-slate-500 text-sm mb-6">Complete the form below. Our shipping desk will negotiate the best carrier quote and contact you to finalize arrangements.</p>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('freight-quote.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Customer Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Your Name</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required 
                               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('customer_name')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required 
                               placeholder="e.g. +1 (555) 019-2834"
                               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="destination_zip" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Destination ZIP Code</label>
                        <input type="text" id="destination_zip" name="destination_zip" value="{{ old('destination_zip') }}" required 
                               placeholder="e.g. 47130"
                               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('destination_zip')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-100 my-4">

                <!-- Lot Details -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-data="{ deliveryType: '{{ old('delivery_type', 'delivery') }}' }">
                    <div class="sm:col-span-2">
                        <label for="product_id" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Select Liquidation Lot</label>
                        <select id="product_id" name="product_id" 
                                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800">
                            <option value="">-- General / Multiple Lots --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" 
                                    {{ (old('product_id') == $p->id || (isset($selectedProductId) && $selectedProductId == $p->id)) ? 'selected' : '' }}>
                                    {{ $p->name }} (${{ number_format($p->price) }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Quantity (Pallets/Loads)</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required 
                               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Delivery Type Options -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ deliveryType: 'delivery' }">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Logistics Preference</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm font-semibold text-zinc-800">
                                <input type="radio" name="delivery_type" value="delivery" x-model="deliveryType" class="text-zinc-950 focus:ring-zinc-950 border-gray-300" checked />
                                <span>Freight Carrier Delivery</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm font-semibold text-zinc-800">
                                <input type="radio" name="delivery_type" value="pickup" x-model="deliveryType" class="text-zinc-950 focus:ring-zinc-950 border-gray-300" />
                                <span>Local Pickup (Warehouse)</span>
                            </label>
                        </div>
                        @error('delivery_type')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="deliveryType === 'delivery'" class="flex items-center pt-5 sm:pt-6">
                        <label class="inline-flex items-center gap-2 cursor-pointer text-sm font-semibold text-zinc-800">
                            <input type="checkbox" name="has_loading_dock" value="1" class="rounded text-zinc-950 focus:ring-zinc-950 border-gray-300" />
                            <span>Destination has a Forklift or Loading Dock</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Inquiry Notes / Special Instructions</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="List any specific requirements, liftgate needs, or residential delivery details..." 
                              class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                    Request Freight Rate Quote
                </button>
            </form>
        </div>
    </section>
@endsection
