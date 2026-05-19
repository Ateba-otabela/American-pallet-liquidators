@extends('layouts.ecommerce')

@section('title', 'Order Confirmed — APL Wholesale')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Confirmation card -->
        <div class="bg-white border border-gray-200 rounded-xl p-8 sm:p-12 shadow-sm text-center mb-10">
            <!-- Success icon -->
            <div class="h-16 w-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>

            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Wholesale Order Received</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-zinc-950 uppercase tracking-tight mb-2">Order Confirmed!</h1>
            <p class="text-slate-500 text-sm font-semibold mb-6">Order Number: <span class="text-zinc-950 font-black">{{ $order->order_number }}</span></p>

            <div class="max-w-md mx-auto py-6 px-8 rounded-lg mb-8 text-sm text-left
                {{ $order->payment_method === 'stripe' ? 'bg-emerald-50/50 border border-emerald-200 text-emerald-800' : 'bg-amber-50/50 border border-amber-200 text-amber-800' }}">
                
                @if($order->payment_method === 'stripe')
                    <span class="block font-black uppercase tracking-wider text-xs mb-1.5 text-emerald-950">Payment Completed Securely</span>
                    <p class="leading-relaxed text-xs">
                        Thank you! Your credit card payment has been successfully processed. Our warehouse logistics team is starting to process your wholesale order. We will reach out to schedule loading dock pickups or arrange nationwide freight transit.
                    </p>
                @else
                    <span class="block font-black uppercase tracking-wider text-xs mb-1.5 text-amber-950">Order Received — Verifying Payment</span>
                    <p class="leading-relaxed text-xs mb-4">
                        We have successfully captured your transaction reference! Our support team is currently verifying your payment. <br><br>
                        <strong>Please be aware that this verification process may take a little bit of time.</strong> Once the funds are confirmed and your order is processed, you will automatically receive an email confirmation containing your shipping and tracking details.
                    </p>
                    
                    <!-- Specific details -->
                    <div class="bg-white p-4 rounded border border-gray-200 text-zinc-800 text-xs font-bold space-y-2">
                        @if($order->payment_method === 'bank_wire')
                            <p class="uppercase tracking-wider text-[10px] text-zinc-400">Bank Wire Details</p>
                            <p>Bank Name: {{ $settings['bank_name'] }}</p>
                            <p>Account Name: {{ $settings['bank_account_name'] }}</p>
                            <p>Routing: {{ $settings['bank_routing_number'] }}</p>
                            <p>Account: {{ $settings['bank_account_number'] }}</p>
                        @elseif($order->payment_method === 'zelle')
                            <p class="uppercase tracking-wider text-[10px] text-zinc-400">Zelle Business Contact</p>
                            <p class="text-zinc-950 text-sm">{{ $settings['zelle_email'] }}</p>
                        @elseif($order->payment_method === 'cash_app')
                            <p class="uppercase tracking-wider text-[10px] text-zinc-400">Business $cashtag</p>
                            <p class="text-zinc-950 text-base">{{ $settings['cash_app_cashtag'] }}</p>
                        @elseif($order->payment_method === 'venmo')
                            <p class="uppercase tracking-wider text-[10px] text-zinc-400">Venmo Profile Handle</p>
                            <p class="text-zinc-950 text-base">{{ $settings['venmo_handle'] }}</p>
                        @elseif($order->payment_method === 'paypal')
                            <p class="uppercase tracking-wider text-[10px] text-zinc-400">PayPal Merchant Email</p>
                            <p class="text-zinc-950">{{ $settings['paypal_email'] }}</p>
                        @elseif($order->payment_method === 'usdt')
                            <p class="uppercase tracking-wider text-[10px] text-zinc-400">USDT Deposit Address</p>
                            <p class="font-mono break-all text-[10px] select-all bg-gray-50 p-2 rounded">{{ $settings['USDT_address'] }}</p>
                        @elseif($order->payment_method === 'cash_on_pickup')
                            <p class="uppercase tracking-wider text-[10px] text-zinc-400">Louisville Warehouse Pickup</p>
                            <p>Address: APL Warehouse, Louisville, KY</p>
                            <p>Instructions: Pay cash in person at loading dock after inspecting pallets.</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('catalog') }}" class="bg-zinc-950 text-white font-extrabold px-8 py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow">
                    Continue Shopping
                </a>
                <a href="tel:5022081035" class="bg-white border border-gray-300 text-zinc-950 font-extrabold px-8 py-3.5 rounded text-xs uppercase tracking-widest hover:bg-gray-100 transition duration-150">
                    Call Logistics Support
                </a>
            </div>
        </div>

        <!-- Order Summary Block -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
            <h2 class="text-lg font-black uppercase tracking-tight text-zinc-950 pb-4 border-b border-gray-100 mb-6">Order Items Summary</h2>
            
            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="py-4 flex gap-4 text-sm font-semibold">
                        <div class="h-16 w-16 bg-gray-50 border border-gray-100 rounded overflow-hidden flex-shrink-0 flex items-center justify-center">
                            <img src="{{ $item->product->first_image_url }}" alt="{{ $item->product->name }}" class="object-cover max-h-full max-w-full" />
                        </div>
                        <div class="flex-grow flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <div>
                                <span class="block font-bold text-zinc-900 uppercase leading-snug">{{ $item->product->name }}</span>
                                <span class="block text-zinc-400 text-xs mt-1">Qty: {{ $item->quantity }} &times; ${{ number_format($item->price) }}</span>
                            </div>
                            <span class="font-extrabold text-zinc-900 text-sm mt-2 sm:mt-0">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-6 border-t border-gray-100 text-sm flex justify-between items-baseline">
                <span class="font-black text-zinc-950 uppercase tracking-widest text-xs">Total Order Value</span>
                <span class="text-xl font-black text-zinc-950">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

    </div>
@endsection
