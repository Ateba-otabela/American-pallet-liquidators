@extends('layouts.admin')

@section('admin_content')
    <div class="space-y-6">
        
        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight">Order Details: {{ $order->order_number }}</h2>
                <span class="text-xs text-zinc-400 font-semibold">Date Placed: {{ $order->created_at->format('M d, Y H:i:s') }}</span>
            </div>
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-zinc-500 hover:text-zinc-950">&larr; Back to all orders</a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-md font-bold text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left: Order Details & Status Updater -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Updater Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <span class="block text-xs font-black uppercase tracking-wider text-zinc-400 mb-1">Current status</span>
                        <span class="text-xs font-black uppercase tracking-wider px-3 py-1 rounded
                            {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-600' : '' }}
                            {{ $order->status === 'processing' || $order->status === 'shipped' ? 'bg-blue-50 text-blue-600' : '' }}
                            {{ $order->status === 'pending_payment' ? 'bg-amber-50 text-amber-600' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-600' : '' }}
                        ">
                            {{ str_replace('_', ' ', $order->status) }}
                        </span>
                    </div>

                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="w-full sm:w-auto flex flex-col gap-3 sm:items-end">
                        @csrf
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full">
                            <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Tracking Number (Optional)" class="bg-gray-50 border border-gray-300 rounded px-3 py-2 text-xs font-bold text-zinc-800 focus:outline-none focus:border-zinc-500 w-full sm:w-48" />
                            <input type="url" name="tracking_url" value="{{ old('tracking_url', $order->tracking_url) }}" placeholder="Tracking URL (Optional)" class="bg-gray-50 border border-gray-300 rounded px-3 py-2 text-xs font-bold text-zinc-800 focus:outline-none focus:border-zinc-500 w-full sm:w-48" />
                        </div>
                        <div class="flex items-center gap-2 w-full justify-end">
                            <select name="status" class="bg-gray-50 border border-gray-300 rounded px-3 py-2 text-xs font-bold text-zinc-800 focus:outline-none focus:border-zinc-500">
                                <option value="pending_payment" {{ $order->status === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="bg-zinc-950 text-white font-extrabold px-4 py-2 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition whitespace-nowrap">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Products Purchased Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 border-b border-gray-100 pb-3 mb-4">Items Summary</h3>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="py-4 flex gap-4 text-xs font-semibold">
                                <div class="h-14 w-14 bg-gray-50 border border-gray-100 rounded overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    <img src="{{ $item->product->first_image_url }}" alt="{{ $item->product->name }}" class="object-cover max-h-full max-w-full" />
                                </div>
                                <div class="flex-grow flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <div>
                                        <span class="block font-bold text-zinc-900 uppercase leading-snug">{{ $item->product->name }}</span>
                                        <span class="block text-zinc-400 text-[10px] mt-1">Qty: {{ $item->quantity }} &times; ${{ number_format($item->price) }}</span>
                                    </div>
                                    <span class="font-extrabold text-zinc-900 text-sm mt-2 sm:mt-0">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-6 border-t border-gray-100 text-sm flex justify-between items-baseline">
                        <span class="font-black text-zinc-950 uppercase tracking-widest text-[10px]">Total Order Value</span>
                        <span class="text-xl font-black text-zinc-950">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Right: Receiver & Payment Summary -->
            <div class="space-y-6">
                <!-- Receiver Details Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 border-b border-gray-100 pb-3">Receiver Information</h3>
                    <div class="text-xs text-slate-500 space-y-2 font-semibold">
                        <p class="text-zinc-900 font-extrabold uppercase text-[10px] tracking-wide">Contact Details</p>
                        <p>
                            Name: <strong class="text-zinc-800">{{ $order->receiver_info['name'] }}</strong><br>
                            Company: <strong class="text-zinc-800">{{ $order->receiver_info['company'] ?? 'None' }}</strong><br>
                            Phone: <strong class="text-zinc-800">{{ $order->receiver_info['phone'] }}</strong><br>
                            Email: <strong class="text-zinc-800">{{ $order->receiver_info['email'] }}</strong>
                        </p>
                        
                        <p class="text-zinc-900 font-extrabold uppercase text-[10px] tracking-wide pt-2">Shipping Destination</p>
                        <address class="not-italic leading-relaxed text-zinc-800">
                            {{ $order->receiver_info['address'] }}<br>
                            {{ $order->receiver_info['city'] }}, {{ $order->receiver_info['state'] }} {{ $order->receiver_info['zip'] }}
                        </address>
                    </div>
                </div>

                <!-- Payment Details Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 border-b border-gray-100 pb-3">Payment details</h3>
                    <div class="text-xs text-slate-500 space-y-2 font-semibold">
                        <p>Method: <strong class="text-zinc-950 uppercase tracking-wide text-[10px]">{{ str_replace('_', ' ', $order->payment_method) }}</strong></p>
                        @if($order->payment_method === 'stripe')
                            <p class="break-all">Stripe Intent ID: <br><strong class="text-zinc-800 font-mono text-[9px]">{{ $order->payment_intent_id ?? 'None' }}</strong></p>
                        @else
                            @if($order->transaction_screenshot)
                                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded text-[11px] font-bold space-y-1 mb-2">
                                    <span class="block text-[10px] font-black uppercase tracking-wider text-blue-500 mb-0.5">Payment Submitted for Review</span>
                                    <p>Ref: <strong class="text-zinc-900 font-mono">{{ $order->transaction_reference }}</strong></p>
                                </div>
                                <div class="mt-3">
                                    <span class="block text-[10px] font-black uppercase tracking-wider text-zinc-400 mb-1">Receipt Screenshot Proof</span>
                                    <a href="{{ $order->transaction_screenshot }}" target="_blank" class="block border border-gray-200 rounded overflow-hidden shadow-sm hover:opacity-90 transition">
                                        <img src="{{ $order->transaction_screenshot }}" alt="Receipt Screenshot" class="object-cover w-full h-auto max-h-48" />
                                    </a>
                                    <span class="block text-[9px] text-zinc-400 italic text-center mt-1">Click image to view full screen</span>
                                </div>
                            @else
                                <p class="text-amber-600 font-bold bg-amber-50 border border-amber-200 p-3 rounded text-[11px] flex flex-col gap-0.5">
                                    <span class="text-[9px] font-black uppercase tracking-wider text-amber-500">Awaiting Proof</span>
                                    Customer has not uploaded payment verification proof yet.
                                </p>
                                @if($order->payment_intent_id)
                                    <p class="bg-gray-50 border border-gray-200 p-2 rounded break-all font-semibold">Checkout Checkout Reference: <strong class="text-zinc-900 font-bold block mt-1">{{ str_replace('Offline Ref: ', '', $order->payment_intent_id) }}</strong></p>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>

                @if($order->payment_method !== 'stripe')
                <!-- Send Payment Details Email Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 border-b border-gray-100 pb-3">Send Payment Details Email</h3>
                    <p class="text-xs text-slate-500 font-semibold mb-2">Send an email to the customer with your <strong class="text-zinc-900 uppercase tracking-wide">{{ str_replace('_', ' ', $order->payment_method) }}</strong> credentials.</p>
                    <form action="{{ route('admin.orders.send-payment-details', $order) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <textarea name="payment_credentials" rows="3" required placeholder="Enter Zelle email, CashApp tag, Wire details, etc..." class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-xs font-bold text-zinc-800 focus:outline-none focus:border-zinc-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-extrabold py-2.5 rounded text-xs uppercase tracking-widest hover:bg-blue-700 transition shadow-sm">
                            Send Email
                        </button>
                    </form>
                </div>
                @endif
            </div>

        </div>

    </div>
@endsection
