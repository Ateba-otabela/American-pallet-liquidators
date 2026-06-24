@extends('layouts.ecommerce')

@section('title', 'Merchant Portal & Dashboard — APL Wholesale')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Welcome banner -->
        <div class="bg-zinc-950 text-white rounded-lg p-6 sm:p-10 shadow-lg mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <!-- Decorative background accent -->
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-zinc-900 rounded-full opacity-50 blur-2xl"></div>
            
            <div class="relative z-10">
                <span class="text-zinc-400 text-xs font-black uppercase tracking-widest block mb-1">APL Merchant Portal</span>
                <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight leading-none mb-2">Welcome Back, {{ auth()->user()->name }}</h1>
                <p class="text-zinc-400 text-xs sm:text-sm max-w-xl leading-relaxed">View your wholesale order history, submit payment screenshots for offline wire/app transfers, and track active logistics status.</p>
            </div>
            
            <div class="relative z-10 flex items-center gap-4 bg-zinc-900/60 border border-zinc-800 rounded px-5 py-3.5 backdrop-blur-sm">
                <div class="h-10 w-10 bg-zinc-800 border border-zinc-700 rounded-full flex items-center justify-center font-black text-sm text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex flex-col text-xs">
                    <span class="font-bold text-white">{{ auth()->user()->email }}</span>
                    <span class="text-zinc-500 font-semibold mt-0.5">Account: Merchant</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold mb-8 text-sm flex items-center gap-2">
                <svg class="h-4 w-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Statistics & Quick Help Grid (Full-Width) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Invoices -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-zinc-400 block mb-1">Total Invoices</span>
                    <h3 class="text-2xl font-black text-zinc-950">{{ $orders->count() }}</h3>
                </div>
                <div class="p-3 bg-zinc-50 border border-zinc-100 rounded-full text-zinc-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>

            <!-- Awaiting Payment -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-zinc-400 block mb-1">Awaiting Payment</span>
                    <h3 class="text-2xl font-black text-amber-600">
                        {{ $orders->where('status', 'pending_payment')->whereNull('transaction_screenshot')->count() }}
                    </h3>
                </div>
                <div class="p-3 bg-amber-50 border border-amber-100 rounded-full text-amber-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Under Review -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-zinc-400 block mb-1">Under Review</span>
                    <h3 class="text-2xl font-black text-blue-600">
                        {{ $orders->where('status', 'pending_payment')->whereNotNull('transaction_screenshot')->count() }}
                    </h3>
                </div>
                <div class="p-3 bg-blue-50 border border-blue-100 rounded-full text-blue-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>

            <!-- Broker Assistance -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-zinc-400 block mb-1">Need Assistance?</span>
                    <p class="text-[10px] text-slate-500 leading-snug font-semibold mt-0.5">Speak with your assigned broker.</p>
                </div>
                <a href="{{ route('contact') }}" class="bg-zinc-950 hover:bg-zinc-800 text-white font-black py-2 px-3 rounded text-[9px] uppercase tracking-wider transition shrink-0 ml-2">
                    Help
                </a>
            </div>
        </div>

        <!-- Full-Width Order History Logs -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-zinc-50">
                <h2 class="text-sm font-black uppercase tracking-wider text-zinc-900">Your Sales Order Logs</h2>
                <span class="text-[10px] text-zinc-400 font-bold uppercase tracking-widest">Showing {{ $orders->count() }} orders</span>
            </div>

            @if($orders->count() === 0)
                <div class="p-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-zinc-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <h3 class="text-sm font-extrabold text-zinc-950 uppercase tracking-tight mb-1">No orders located</h3>
                    <p class="text-slate-500 text-xs max-w-sm mx-auto mb-6 leading-relaxed">You haven't placed any wholesale lot or pallet orders yet. Visit our liquidation catalog to create your first order.</p>
                    <a href="{{ route('catalog') }}" class="bg-zinc-950 text-white font-extrabold px-5 py-3 rounded text-[10px] uppercase tracking-widest hover:bg-zinc-800 transition shadow">Browse Catalog</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-[10px] font-black uppercase tracking-wider text-zinc-400">
                                <th class="p-4 sm:p-5">Order #</th>
                                <th class="p-4 sm:p-5">Date Placed</th>
                                <th class="p-4 sm:p-5">Lot Items</th>
                                <th class="p-4 sm:p-5">Total Value</th>
                                <th class="p-4 sm:p-5">Status</th>
                                <th class="p-4 sm:p-5 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs font-semibold text-zinc-800">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <!-- Order Number -->
                                    <td class="p-4 sm:p-5 font-bold text-zinc-900 leading-tight">
                                        {{ $order->order_number }}
                                        <span class="block text-[9px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                                    </td>
                                    
                                    <!-- Date Placed -->
                                    <td class="p-4 sm:p-5 text-zinc-500 font-medium">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    
                                    <!-- Lot Items -->
                                    <td class="p-4 sm:p-5 max-w-xs truncate text-zinc-600 leading-snug">
                                        @foreach($order->items as $item)
                                            <span class="block font-bold text-zinc-800">{{ $item->product->name ?? 'Wholesale Lot' }} <span class="text-zinc-400 font-medium">&times; {{ $item->quantity }}</span></span>
                                        @endforeach
                                    </td>
                                    
                                    <!-- Total Value -->
                                    <td class="p-4 sm:p-5 font-black text-zinc-950">
                                        ${{ number_format($order->total, 2) }}
                                    </td>
                                    
                                    <!-- Status with proof checks -->
                                    <td class="p-4 sm:p-5">
                                        @if($order->status === 'pending_payment')
                                            @if($order->transaction_screenshot)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-blue-50 text-blue-600 font-black uppercase text-[9px] tracking-wider border border-blue-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                    Under Review
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-amber-50 text-amber-600 font-black uppercase text-[9px] tracking-wider border border-amber-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    Pending Payment
                                                </span>
                                            @endif
                                        @elseif($order->status === 'processing')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-emerald-50 text-emerald-600 font-black uppercase text-[9px] tracking-wider border border-emerald-100">
                                                Paid / Processing
                                            </span>
                                        @elseif($order->status === 'shipped')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-blue-50 text-blue-600 font-black uppercase text-[9px] tracking-wider border border-blue-100">
                                                Shipped
                                            </span>
                                        @elseif($order->status === 'delivered')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-slate-100 text-slate-700 font-black uppercase text-[9px] tracking-wider border border-slate-200">
                                                Delivered
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-red-50 text-red-600 font-black uppercase text-[9px] tracking-wider border border-red-100">
                                                {{ strtoupper($order->status) }}
                                            </span>
                                        @endif

                                        <!-- Show tracking details if exists -->
                                        @if($order->tracking_number)
                                            <span class="block text-[9px] text-slate-500 mt-1 font-semibold leading-none">
                                                Tracking: 
                                                @if($order->tracking_url)
                                                    <a href="{{ $order->tracking_url }}" target="_blank" class="underline font-bold text-zinc-950 hover:text-zinc-600">{{ $order->tracking_number }}</a>
                                                @else
                                                    <span class="font-bold text-zinc-800">{{ $order->tracking_number }}</span>
                                                @endif
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Action Button -->
                                    <td class="p-4 sm:p-5 text-right whitespace-nowrap">
                                        @if($order->status === 'pending_payment' && !$order->transaction_screenshot)
                                            <div class="flex flex-col sm:flex-row gap-2 items-end sm:items-center justify-end">
                                                <form action="{{ route('orders.request-payment-email', $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" title="Resend payment details email" class="bg-gray-500 hover:bg-gray-600 text-white font-extrabold text-[9px] uppercase tracking-widest px-2.5 py-2 rounded transition shadow-sm leading-none">
                                                        Email
                                                    </button>
                                                </form>
                                                <button 
                                                    onclick="openPaymentModal('{{ $order->id }}', '{{ $order->order_number }}', '{{ str_replace('_', ' ', $order->payment_method) }}')" 
                                                    class="bg-zinc-950 hover:bg-zinc-800 text-white font-extrabold text-[9px] uppercase tracking-widest px-3.5 py-2 rounded transition shadow-sm leading-none"
                                                >
                                                    Complete Order
                                                </button>
                                            </div>
                                        @elseif($order->status === 'pending_payment' && $order->transaction_screenshot)
                                            <button 
                                                disabled
                                                class="bg-gray-100 text-zinc-400 font-extrabold text-[9px] uppercase tracking-widest px-3.5 py-2 rounded cursor-not-allowed leading-none"
                                            >
                                                Awaiting Review
                                            </button>
                                        @else
                                            <span class="text-[10px] text-zinc-400 font-bold uppercase tracking-wider">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Complete Payment Modal (Popup) -->
    <div id="paymentModal" class="fixed inset-0 z-50 overflow-y-auto bg-zinc-950/80 backdrop-blur-sm hidden items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white border border-gray-200 rounded-lg max-w-md w-full shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCard">
            
            <!-- Modal Header -->
            <div class="bg-zinc-950 text-white p-6 relative">
                <button onclick="closePaymentModal()" class="absolute right-4 top-4 text-zinc-400 hover:text-white transition focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <span class="text-zinc-400 text-[9px] font-black uppercase tracking-widest block mb-1">Verify Wire / Wallet Receipt</span>
                <h3 class="text-lg font-black uppercase tracking-tight">Complete Payment Proof</h3>
            </div>

            <!-- Modal Form -->
            <form id="paymentForm" onsubmit="submitPaymentProof(event)" class="p-6 sm:p-8 space-y-5" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" id="modalOrderId" />
                
                <div class="space-y-1">
                    <label class="block text-[10px] font-black uppercase tracking-wider text-zinc-500">Selected Method</label>
                    <div id="modalPaymentMethod" class="bg-gray-50 border border-gray-200 rounded px-3 py-2 text-xs font-bold text-zinc-950 uppercase tracking-wide">
                        Offline Method
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="modalOrderNum" class="block text-[10px] font-black uppercase tracking-wider text-zinc-500">Order Number</label>
                    <input type="text" id="modalOrderNum" readonly class="w-full bg-gray-50 border border-gray-200 rounded px-3 py-2 text-xs font-extrabold text-zinc-900 focus:outline-none cursor-not-allowed" />
                </div>

                <div class="space-y-1.5">
                    <label for="transaction_reference" class="block text-[10px] font-black uppercase tracking-wider text-zinc-500">Transaction Reference / Ref Number</label>
                    <input type="text" name="transaction_reference" id="transaction_reference" required placeholder="Zelle ID, Wire Ref #, Wallet Hash" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2.5 text-xs font-bold text-zinc-900 placeholder-zinc-400 focus:outline-none focus:border-zinc-950 transition" />
                </div>

                <div class="space-y-1.5">
                    <label for="transaction_screenshot" class="block text-[10px] font-black uppercase tracking-wider text-zinc-500">Upload Transaction Screenshot / Receipt</label>
                    <input type="file" name="transaction_screenshot" id="transaction_screenshot" required accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 text-xs font-bold text-zinc-600 focus:outline-none focus:border-zinc-950 transition file:mr-4 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-zinc-950 file:text-white hover:file:bg-zinc-800 file:cursor-pointer" />
                    <p class="text-[9px] text-zinc-400 font-semibold">Accepted formats: PNG, JPG, JPEG. Max file size: 10MB.</p>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2.5 border border-gray-300 text-zinc-700 font-extrabold rounded text-[10px] uppercase tracking-wider hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="px-5 py-2.5 bg-zinc-950 hover:bg-zinc-800 text-white font-extrabold rounded text-[10px] uppercase tracking-widest hover:shadow transition flex items-center gap-2">
                        <svg id="spinner" class="animate-spin h-3 w-3 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Submit Details
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Feedback Modal (Popup) -->
    <div id="successModal" class="fixed inset-0 z-50 overflow-y-auto bg-zinc-950/85 backdrop-blur-sm hidden items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white border border-gray-200 rounded-lg max-w-sm w-full shadow-2xl p-6 sm:p-8 text-center overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="successCard">
            
            <div class="mx-auto h-12 w-12 bg-emerald-50 border border-emerald-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            
            <h3 class="text-lg font-black uppercase tracking-tight text-zinc-900 mb-2">Details Submitted</h3>
            <p class="text-xs text-slate-500 leading-relaxed font-semibold mb-6">We are currently checking the payment details you submitted. Once our accounting department verifies the transaction on our end, your order status will be updated immediately.</p>
            
            <button onclick="dismissSuccessModal()" class="w-full bg-zinc-950 hover:bg-zinc-800 text-white font-extrabold py-3 rounded text-[10px] uppercase tracking-widest transition">
                Acknowledge
            </button>
        </div>
    </div>

    <!-- JavaScript Actions & AJAX handler -->
    <script>
        function openPaymentModal(orderId, orderNum, paymentMethod) {
            const modal = document.getElementById('paymentModal');
            const card = document.getElementById('modalCard');
            
            // Set fields
            document.getElementById('modalOrderId').value = orderId;
            document.getElementById('modalOrderNum').value = orderNum;
            document.getElementById('modalPaymentMethod').innerText = paymentMethod;
            
            // Clean form inputs
            document.getElementById('transaction_reference').value = '';
            document.getElementById('transaction_screenshot').value = '';
            
            // Show modal and apply animations
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closePaymentModal() {
            const modal = document.getElementById('paymentModal');
            const card = document.getElementById('modalCard');
            
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        function submitPaymentProof(e) {
            e.preventDefault();
            
            const form = document.getElementById('paymentForm');
            const orderId = document.getElementById('modalOrderId').value;
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('spinner');
            
            // Disable button and show spinner
            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch(`/orders/${orderId}/complete-payment`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Verification request failed. Please verify files are correct format.');
                }
                return response.json();
            })
            .then(data => {
                // Hide completion modal
                closePaymentModal();
                
                // Show success feedback popup
                setTimeout(() => {
                    openSuccessModal();
                }, 350);
            })
            .catch(error => {
                console.error('Submission failed:', error);
                alert('Verification submission failed. Please verify that your screenshot is an image and try again.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
            });
        }

        function openSuccessModal() {
            const modal = document.getElementById('successModal');
            const card = document.getElementById('successCard');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function dismissSuccessModal() {
            const modal = document.getElementById('successModal');
            const card = document.getElementById('successCard');
            
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                // Reload page to update the status and remove button
                window.location.reload();
            }, 300);
        }
    </script>
@endsection
