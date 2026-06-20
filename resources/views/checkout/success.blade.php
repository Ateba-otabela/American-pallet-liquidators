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
                    <span class="block font-black uppercase tracking-wider text-xs mb-1.5 text-amber-950">Order Placed — Payment Required</span>
                    <p class="leading-relaxed text-xs mb-4">
                        We have successfully received your wholesale order! However, it is currently pending payment. <br><br>
                        <strong>Please go to your account dashboard to view the payment credentials for your selected method, complete the transaction, and submit your payment screenshot and ID.</strong> Once verified, your order will be shipped.
                    </p>
                    
                    <a href="{{ route('dashboard') }}" class="inline-block bg-zinc-950 text-white font-bold px-6 py-2.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition shadow">
                        Go to My Dashboard
                    </a>
                @endif
            </div>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('catalog') }}" class="bg-zinc-950 text-white font-extrabold px-8 py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow">
                    Continue Shopping
                </a>
                <a href="tel:+447882769759" class="bg-white border border-gray-300 text-zinc-950 font-extrabold px-8 py-3.5 rounded text-xs uppercase tracking-widest hover:bg-gray-100 transition duration-150">
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($order->payment_method !== 'stripe')
            Swal.fire({
                icon: 'success',
                title: 'Order Placed Successfully!',
                text: 'Please go to your orders to view your payment credentials, complete the payment, and submit your transaction screenshot and ID.',
                confirmButtonText: 'Go to Dashboard',
                confirmButtonColor: '#18181b',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('dashboard') }}";
                }
            });
            @endif
        });
    </script>
@endsection
