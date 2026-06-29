@extends('layouts.ecommerce')

@section('title', 'Checkout Step 2 — Select Payment Method')

@section('content')
    <!-- Include Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    
    <!-- Include PayPal JS SDK (using a placeholder client-id if none is set in env) -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id', 'test') }}&currency=USD"></script>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="checkoutHandler()">
        
        <!-- Steps Breadcrumbs -->
        <div class="flex items-center justify-center gap-4 sm:gap-8 mb-12 text-xs font-black uppercase tracking-wider text-center">
            <span class="text-zinc-400">01. Receiver Info</span>
            <span class="text-zinc-300">&rarr;</span>
            <span class="text-zinc-950 border-b-2 border-zinc-950 pb-1">02. Select Payment</span>
            <span class="text-zinc-300">&rarr;</span>
            <span class="text-zinc-300">03. Order Confirmation</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            <!-- Left: Payment Methods Selection -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-6">Select Payment Method</h2>
                    
                    <!-- Form submitting to process payment -->
                    <form id="payment-form" action="{{ route('checkout.processPayment') }}" method="POST" @submit.prevent="submitCheckout">
                        @csrf
                        <input type="hidden" name="payment_method" :value="paymentMethod" />
                        <input type="hidden" name="payment_intent_id" x-model="paymentIntentId" />

                        <!-- Methods grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            
                            <!-- Stripe Card option -->
                            <label :class="paymentMethod === 'stripe' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="stripe" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Debit / Credit Card</span>
                                    <span class="block text-slate-500 text-xs mt-1">Pay instantly via Stripe secure card elements.</span>
                                </div>
                            </label>

                            <!-- Bank Wire option -->
                            <label :class="paymentMethod === 'bank_wire' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="bank_wire" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Bank Wire Transfer</span>
                                    <span class="block text-slate-500 text-xs mt-1">Direct wire to Chase Bank. Perfect for large orders.</span>
                                </div>
                            </label>

                            <!-- Zelle option -->
                            <label :class="paymentMethod === 'zelle' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="zelle" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Zelle Business</span>
                                    <span class="block text-slate-500 text-xs mt-1">Instant, no-fee Zelle business bank pay.</span>
                                </div>
                            </label>

                            <!-- Cash App option -->
                            <label :class="paymentMethod === 'cash_app' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="cash_app" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Cash App</span>
                                    <span class="block text-slate-500 text-xs mt-1">Pay instantly to our business $cashtag handle.</span>
                                </div>
                            </label>

                            <!-- Venmo option -->
                            <label :class="paymentMethod === 'venmo' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="venmo" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Venmo</span>
                                    <span class="block text-slate-500 text-xs mt-1">Simple transfer via mobile Venmo handle.</span>
                                </div>
                            </label>

                            <!-- PayPal option -->
                            <label :class="paymentMethod === 'paypal' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="paypal" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">PayPal</span>
                                    <span class="block text-slate-500 text-xs mt-1">Pay via PayPal transfer or standard balance.</span>
                                </div>
                            </label>

                            <!-- Crypto USDT option -->
                            <label :class="paymentMethod === 'usdt' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="usdt" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Cryptocurrency USDT</span>
                                    <span class="block text-slate-500 text-xs mt-1">Secure settlement in USDT (TRC20 / ERC20).</span>
                                </div>
                            </label>

                            <!-- Pickup option -->
                            <label :class="paymentMethod === 'cash_on_pickup' ? 'border-zinc-950 ring-2 ring-zinc-950 bg-zinc-50' : 'border-gray-200 hover:border-gray-300 bg-white'" class="border rounded-lg p-5 flex items-start gap-4 cursor-pointer transition">
                                <input type="radio" name="method_selector" value="cash_on_pickup" x-model="paymentMethod" class="text-zinc-950 focus:ring-zinc-950 border-gray-300 mt-1" />
                                <div>
                                    <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs">Cash on Pickup</span>
                                    <span class="block text-slate-500 text-xs mt-1">Inspect and pay cash at our Louisville warehouse.</span>
                                </div>
                            </label>

                        </div>

                        <!-- Payment details dynamic panels -->
                        <div class="bg-gray-100 border border-gray-200 rounded-lg p-6 mb-8 text-sm">
                            
                            <!-- Stripe card elements layout panel -->
                            <div x-show="paymentMethod === 'stripe'" class="space-y-4">
                                <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs mb-2">Secure Credit / Debit Card</span>
                                
                                <div class="bg-white border border-gray-300 rounded-lg p-4 shadow-sm space-y-4">
                                    <div id="payment-request-button" class="mb-4 hidden">
                                        <!-- A Stripe Element will be inserted here for Apple Pay / Google Pay. -->
                                    </div>
                                    <div id="prb-divider" class="relative flex items-center gap-3 my-4 hidden">
                                        <div class="flex-grow border-t border-gray-200"></div>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">or pay with card</span>
                                        <div class="flex-grow border-t border-gray-200"></div>
                                    </div>
                                    <div class="pt-2">
                                        <div id="card-element" class="w-full p-2.5 border border-gray-200 rounded text-sm bg-gray-50"></div>
                                    </div>
                                </div>
                                <div id="card-errors" class="text-rose-600 text-xs font-semibold" role="alert"></div>
                            </div>

                            <!-- PayPal Smart Buttons container -->
                            <div x-show="paymentMethod === 'paypal'" class="space-y-4" style="display: none;">
                                <span class="block font-extrabold text-zinc-950 uppercase tracking-wider text-xs mb-2">PayPal Checkout</span>
                                <div class="bg-white border border-gray-300 rounded-lg p-4 shadow-sm">
                                    <!-- This container is where the PayPal buttons will render -->
                                    <div id="paypal-button-container" class="w-full relative z-0"></div>
                                </div>
                            </div>

                            <!-- Offline payment info has been moved to the user dashboard -->

                        </div>

                        <!-- Button to submit -->
                        <button type="submit" :disabled="loading" class="w-full bg-zinc-950 text-white font-extrabold py-4 rounded text-sm uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md flex justify-center items-center gap-2">
                            <svg x-show="loading" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span x-text="loading ? 'Processing Transaction...' : 'Place Wholesale Order'"></span>
                        </button>
                    </form>

                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
                <h3 class="text-lg font-black uppercase tracking-tight text-zinc-950 pb-4 border-b border-gray-100">Delivery Summary</h3>
                
                <!-- Shipping Address details -->
                <div class="text-xs text-slate-500 space-y-2">
                    <p class="font-bold text-zinc-800 uppercase tracking-wide">Receiver Details</p>
                    <p class="leading-relaxed">
                        Name: <strong>{{ $shipping['name'] }}</strong><br>
                        Company: <strong>{{ $shipping['company'] ?? 'None' }}</strong><br>
                        Phone: <strong>{{ $shipping['phone'] }}</strong><br>
                        Email: <strong>{{ $shipping['email'] }}</strong>
                    </p>
                    <p class="font-bold text-zinc-800 uppercase tracking-wide pt-2">Shipping Destination</p>
                    <address class="not-italic leading-relaxed">
                        {{ $shipping['address'] }}<br>
                        {{ $shipping['city'] }}, {{ $shipping['state'] }} {{ $shipping['zip'] }}
                    </address>
                    <a href="{{ route('checkout.step1') }}" class="block font-bold text-zinc-950 hover:underline pt-2 uppercase tracking-wide">Edit Details &rarr;</a>
                </div>

                <hr class="border-gray-100">

                <!-- Totals -->
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between font-semibold text-slate-500">
                        <span>Items Subtotal</span>
                        <span class="text-zinc-950 font-extrabold">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-slate-500 pb-3 border-b border-gray-100">
                        <span>Shipping Freight</span>
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

    <!-- Alpine Checkout state handler -->
    <script>
        function checkoutHandler() {
            return {
                paymentMethod: 'stripe',
                paymentIntentId: '',
                loading: false,
                stripe: null,
                card: null,
                stripePublicKey: '{{ $settings['stripe_publishable_key'] }}',

                init() {
                    this.initStripe();
                    this.initPayPal();
                },

                async initStripe() {
                    // Avoid initializing if public key is not configured/default placeholder
                    if (!this.stripePublicKey || this.stripePublicKey === 'pk_test_placeholder') {
                        console.warn("Stripe public key is placeholder. Falling back to mock transaction simulation.");
                        return;
                    }

                    try {
                        this.stripe = Stripe(this.stripePublicKey);
                        const elements = this.stripe.elements();
                        
                        // Custom styling for elements to fit premium zinc look
                        const style = {
                            base: {
                                color: '#18181b',
                                fontFamily: "'Outfit', sans-serif",
                                fontSmoothing: 'antialiased',
                                fontSize: '15px',
                                '::placeholder': {
                                    color: '#a1a1aa'
                                }
                            },
                            invalid: {
                                color: '#dc2626',
                                iconColor: '#dc2626'
                            }
                        };

                        this.card = elements.create('card', { style: style, hidePostalCode: true });
                        this.card.mount('#card-element');

                        // Error listener
                        this.card.on('change', (event) => {
                            const displayError = document.getElementById('card-errors');
                            if (event.error) {
                                displayError.textContent = event.error.message;
                            } else {
                                displayError.textContent = '';
                            }
                        });

                        // ----------------------------------------------------
                        // Payment Request Button (Apple Pay / Google Pay)
                        // ----------------------------------------------------
                        const paymentRequest = this.stripe.paymentRequest({
                            country: 'US',
                            currency: 'usd',
                            total: {
                                label: 'Total',
                                amount: parseInt('{{ $total * 100 }}'), // amount in cents
                            },
                            requestPayerName: true,
                            requestPayerEmail: true,
                        });

                        const prButton = elements.create('paymentRequestButton', {
                            paymentRequest: paymentRequest,
                            style: {
                                paymentRequestButton: {
                                    type: 'default',
                                    theme: 'dark', // 'dark' | 'light' | 'light-outline'
                                    height: '44px',
                                },
                            },
                        });

                        // Check the availability of the Payment Request API
                        paymentRequest.canMakePayment().then((result) => {
                            if (result) {
                                document.getElementById('payment-request-button').classList.remove('hidden');
                                document.getElementById('prb-divider').classList.remove('hidden');
                                prButton.mount('#payment-request-button');
                            }
                        });

                        paymentRequest.on('paymentmethod', async (ev) => {
                            this.loading = true;
                            // Fetch payment intent from backend
                            const response = await fetch('{{ route('checkout.createPaymentIntent') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            });
                            
                            const data = await response.json();
                            if (data.error) {
                                ev.complete('fail');
                                alert("Error starting transaction: " + data.error);
                                this.loading = false;
                                return;
                            }

                            // Confirm the PaymentIntent with the payment method
                            const {paymentIntent, error: confirmError} = await this.stripe.confirmCardPayment(
                                data.clientSecret,
                                {payment_method: ev.paymentMethod.id},
                                {handleActions: false}
                            );

                            if (confirmError) {
                                ev.complete('fail');
                                document.getElementById('card-errors').textContent = confirmError.message;
                                this.loading = false;
                            } else {
                                ev.complete('success');
                                if (paymentIntent.status === "requires_action") {
                                    const {error} = await this.stripe.confirmCardPayment(data.clientSecret);
                                    if (error) {
                                        document.getElementById('card-errors').textContent = error.message;
                                        this.loading = false;
                                    } else {
                                        this.submitFinalStripeOrder(paymentIntent.id);
                                    }
                                } else {
                                    this.submitFinalStripeOrder(paymentIntent.id);
                                }
                            }
                        });

                    } catch (e) {
                        console.error("Stripe elements error:", e);
                    }
                },

                async submitCheckout() {
                    this.loading = true;

                    // If offline payment or mock/unconfigured Stripe
                    if (this.paymentMethod !== 'stripe' || !this.stripe || this.stripePublicKey === 'pk_test_placeholder') {
                        // Submit immediately to create the order
                        document.getElementById('payment-form').submit();
                        return;
                    }

                    // Process Stripe credit card payment manually
                    try {
                        // 1. Fetch payment intent from backend
                        const response = await fetch('{{ route('checkout.createPaymentIntent') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const data = await response.json();
                        if (data.error) {
                            alert("Error starting transaction: " + data.error);
                            this.loading = false;
                            return;
                        }

                        const clientSecret = data.clientSecret;

                        // 2. Confirm card payment
                        const result = await this.stripe.confirmCardPayment(clientSecret, {
                            payment_method: {
                                card: this.card,
                                billing_details: {
                                    name: '{{ $shipping['name'] }}',
                                    email: '{{ $shipping['email'] }}',
                                    phone: '{{ $shipping['phone'] }}'
                                }
                            }
                        });

                        if (result.error) {
                            const errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                            this.loading = false;
                        } else {
                            if (result.paymentIntent.status === 'succeeded') {
                                this.submitFinalStripeOrder(result.paymentIntent.id);
                            }
                        }
                    } catch (e) {
                        console.error(e);
                        alert("An error occurred during Stripe verification. Falling back to mock transaction simulation.");
                        document.getElementById('payment-form').submit();
                    }
                },

                submitFinalStripeOrder(intentId) {
                    this.paymentIntentId = intentId;
                    this.paymentMethod = 'stripe'; // Ensure method is stripe if prb triggered it while viewing another tab
                    setTimeout(() => {
                        document.getElementById('payment-form').submit();
                    }, 300);
                },

                initPayPal() {
                    try {
                        if (typeof paypal !== 'undefined') {
                            paypal.Buttons({
                                // Set up the transaction
                                createOrder: (data, actions) => {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: '{{ number_format($total, 2, '.', '') }}'
                                            }
                                        }]
                                    });
                                },
                                // Finalize the transaction
                                onApprove: (data, actions) => {
                                    return actions.order.capture().then((details) => {
                                        // The transaction was successful!
                                        this.paymentIntentId = details.id; // Store PayPal transaction ID
                                        this.paymentMethod = 'paypal'; // Explicitly set method
                                        
                                        // Submit the main form
                                        document.getElementById('payment-form').submit();
                                    });
                                },
                                onError: (err) => {
                                    console.error('PayPal Checkout onError', err);
                                    alert("An error occurred during PayPal checkout. Please try again or choose another payment method.");
                                }
                            }).render('#paypal-button-container');
                        }
                    } catch (e) {
                        console.error("PayPal elements error:", e);
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
