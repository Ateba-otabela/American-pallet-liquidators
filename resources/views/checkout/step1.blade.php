@extends('layouts.ecommerce')

@section('title', 'Checkout Step 1 — Shipping &amp; Receiver Information')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Steps Breadcrumbs -->
        <div class="flex items-center justify-center gap-4 sm:gap-8 mb-12 text-xs font-black uppercase tracking-wider text-center">
            <span class="text-zinc-950 border-b-2 border-zinc-950 pb-1">01. Receiver Info</span>
            <span class="text-zinc-300">&rarr;</span>
            <span class="text-zinc-300">02. Select Payment</span>
            <span class="text-zinc-300">&rarr;</span>
            <span class="text-zinc-300">03. Order Confirmation</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            <!-- Left: Receiver Form -->
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-6">Receiver &amp; Delivery Details</h2>
                
                <form action="{{ route('checkout.submitStep1') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Receiver / Company Contact Name *</label>
                            <input type="text" id="name" name="name" required value="{{ old('name', $shipping['name'] ?? '') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="company" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Company Name (Optional)</label>
                            <input type="text" id="company" name="company" value="{{ old('company', $shipping['company'] ?? '') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('company') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Email Address * (For receipts &amp; wire details)</label>
                            <input type="email" id="email" name="email" required value="{{ old('email', $shipping['email'] ?? '') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('email') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Receiver Phone Number *</label>
                            <input type="text" id="phone" name="phone" required value="{{ old('phone', $shipping['phone'] ?? '') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('phone') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Delivery Street Address *</label>
                        <input type="text" id="address" name="address" required value="{{ old('address', $shipping['address'] ?? '') }}" placeholder="123 Wholesale Lane, Suite A" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('address') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label for="city" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">City *</label>
                            <input type="text" id="city" name="city" required value="{{ old('city', $shipping['city'] ?? '') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('city') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="state" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">State *</label>
                            <input type="text" id="state" name="state" required value="{{ old('state', $shipping['state'] ?? '') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('state') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="zip" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">ZIP Code *</label>
                            <input type="text" id="zip" name="zip" required value="{{ old('zip', $shipping['zip'] ?? '') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                            @error('zip') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-md">
                        <span class="block text-blue-800 text-xs font-black uppercase tracking-wider mb-1">Commercial vs Residential Freight Notice</span>
                        <p class="text-blue-700 text-xs leading-relaxed">
                            Wholesale freight carriers bill separately. Commercial dock addresses receive significantly lower carrier rates. If you request shipping, our logistics team will calculate custom freight solutions to optimize your transport costs.
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-4 rounded text-sm uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                        Continue to Payment Method
                    </button>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
                <h3 class="text-lg font-black uppercase tracking-tight text-zinc-950 pb-4 border-b border-gray-100">Merchandise list</h3>
                
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto">
                    @foreach($cart as $item)
                        <div class="py-4 flex gap-4 text-xs font-semibold">
                            <div class="h-12 w-12 bg-gray-50 border border-gray-100 rounded overflow-hidden flex-shrink-0 flex items-center justify-center">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="object-cover max-h-full max-w-full" />
                            </div>
                            <div class="flex-grow">
                                <span class="block font-bold text-zinc-900 uppercase leading-snug line-clamp-2">{{ $item['name'] }}</span>
                                <span class="block text-zinc-400 mt-1">Qty: {{ $item['quantity'] }} &times; ${{ number_format($item['price']) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-gray-100 space-y-3 text-sm">
                    <div class="flex justify-between font-semibold text-slate-500">
                        <span>Items Subtotal</span>
                        <span class="text-zinc-950 font-extrabold">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-slate-500 pb-3 border-b border-gray-100">
                        <span>Shipping freight</span>
                        <span class="text-zinc-500 italic">Billed Separately</span>
                    </div>
                    <div class="flex justify-between items-baseline pt-2">
                        <span class="font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Total Due</span>
                        <span class="text-2xl font-black text-zinc-950">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
