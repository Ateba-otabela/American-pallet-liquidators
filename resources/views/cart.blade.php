@extends('layouts.ecommerce')

@section('title', 'Shopping Cart — APL Wholesale')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-zinc-950 uppercase tracking-tight mb-8">Your Shopping Cart</h1>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md font-bold mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) === 0)
            <div class="bg-white border border-gray-200 rounded-lg p-16 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-zinc-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <h3 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight mb-2">Your cart is empty</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto mb-8">Browse our wholesale liquidation catalog and add some pallets or truckloads to get started.</p>
                <a href="{{ route('catalog') }}" class="bg-zinc-950 text-white font-extrabold px-6 py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition shadow">Continue Shopping</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
                
                <!-- Left: Items list -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-black uppercase tracking-wider text-zinc-400">
                                    <th class="p-6">Product</th>
                                    <th class="p-6 text-center">Quantity</th>
                                    <th class="p-6 text-right">Price</th>
                                    <th class="p-6 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($cart as $item)
                                    <tr class="text-sm">
                                        <!-- Image and Name -->
                                        <td class="p-6 flex items-center gap-4">
                                            <div class="h-16 w-16 bg-gray-50 border border-gray-100 rounded overflow-hidden flex-shrink-0 flex items-center justify-center">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="object-cover max-h-full max-w-full" />
                                            </div>
                                            <div>
                                                <h3 class="font-extrabold text-zinc-900 uppercase tracking-tight hover:text-zinc-600 transition leading-tight mb-1">
                                                    <a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                                </h3>
                                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">Remove item</button>
                                                </form>
                                            </div>
                                        </td>
                                        <!-- Quantity update -->
                                        <td class="p-6 text-center">
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline-flex items-center gap-2">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" class="w-16 bg-gray-50 border border-gray-300 rounded px-2 py-1 text-center text-sm font-bold text-zinc-800 focus:outline-none focus:border-zinc-500" />
                                                <button type="submit" class="bg-gray-100 text-zinc-700 hover:bg-gray-200 font-extrabold px-2.5 py-1 rounded text-xs uppercase tracking-wider transition">Update</button>
                                            </form>
                                        </td>
                                        <!-- Unit Price -->
                                        <td class="p-6 text-right font-semibold text-zinc-600">
                                            ${{ number_format($item['price'], 2) }}
                                        </td>
                                        <!-- Subtotal -->
                                        <td class="p-6 text-right font-extrabold text-zinc-900">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Summary Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
                    <h2 class="text-lg font-black uppercase tracking-tight text-zinc-950 pb-4 border-b border-gray-100">Order Summary</h2>

                    <!-- Costs -->
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between font-semibold text-slate-500">
                            <span>Subtotal</span>
                            <span class="text-zinc-950 font-extrabold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-semibold text-slate-500">
                            <span>Shipping Logistics</span>
                            <span class="text-zinc-500 italic">Billed Separately</span>
                        </div>
                        <div class="flex justify-between font-semibold text-slate-500 pb-3 border-b border-gray-100">
                            <span>Forklift Loading</span>
                            <span class="text-emerald-600 font-bold uppercase tracking-wider text-xs">Free</span>
                        </div>
                        <div class="flex justify-between items-baseline pt-2">
                            <span class="font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Total Due Now</span>
                            <span class="text-2xl font-black text-zinc-950">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Checkout CTA -->
                    <div class="pt-4">
                        <a href="{{ route('checkout.step1') }}" class="block w-full bg-zinc-950 text-white font-extrabold text-center py-4 rounded text-sm uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                            Proceed to Checkout
                        </a>
                        <a href="{{ route('catalog') }}" class="block text-center text-xs font-bold text-zinc-500 hover:text-zinc-900 transition mt-4">
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Trust factors -->
                    <div class="bg-zinc-50 border border-gray-100 rounded p-4 space-y-2 text-xs text-slate-500">
                        <p class="font-bold text-zinc-800 flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Wholesale Merchant Protection
                        </p>
                        <p class="leading-relaxed">All card information is processed directly by Stripe Elements. No raw credentials touch our database. Bank routing and wallet details are provided during step 2.</p>
                    </div>
                </div>

            </div>
        @endif
    </div>
@endsection
