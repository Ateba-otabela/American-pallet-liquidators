<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    /**
     * Show checkout Step 1 (Shipping/Receiver details).
     */
    public function showStep1()
    {
        $cart = session()->get('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $shipping = session()->get('checkout_shipping', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.step1', compact('shipping', 'total', 'cart'));
    }

    /**
     * Submit Step 1 details and redirect to payment.
     */
    public function submitStep1(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
        ]);

        session()->put('checkout_shipping', $validated);

        return redirect()->route('checkout.payment');
    }

    /**
     * Show checkout Step 2 (Payment).
     */
    public function showPayment()
    {
        $cart = session()->get('cart', []);
        $shipping = session()->get('checkout_shipping');

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        if (!$shipping) {
            return redirect()->route('checkout.step1')->with('error', 'Please fill in your shipping details first.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Get offline payment details from settings
        $settings = [
            'bank_name' => Setting::get('bank_name', 'Chase Bank'),
            'bank_account_name' => Setting::get('bank_account_name', 'American Pallet Liquidators LLC'),
            'bank_routing_number' => Setting::get('bank_routing_number', '123456789'),
            'bank_account_number' => Setting::get('bank_account_number', '9876543210'),
            'cash_app_cashtag' => Setting::get('cash_app_cashtag', '$aplpallets'),
            'zelle_email' => Setting::get('zelle_email', 'zelle@aplpallets.com'),
            'USDT_address' => Setting::get('USDT_address', '0x1234567890abcdef1234567890abcdef12345678'),
            'venmo_handle' => Setting::get('venmo_handle', '@aplpallets'),
            'paypal_email' => Setting::get('paypal_email', 'paypal@aplpallets.com'),
            'stripe_publishable_key' => Setting::get('stripe_publishable_key', 'pk_test_placeholder'),
        ];

        return view('checkout.payment', compact('cart', 'shipping', 'total', 'settings'));
    }

    /**
     * Create Stripe Payment Intent for Card Payment.
     */
    public function createPaymentIntent(Request $request)
    {
        $cart = session()->get('cart', []);
        if (count($cart) === 0) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $stripeSecret = Setting::get('stripe_secret_key');
        if (!$stripeSecret || $stripeSecret === 'sk_test_placeholder') {
            // For local study purposes, use dummy key if not set, or return local demo secret
            Stripe::setApiKey(env('STRIPE_SECRET_KEY', 'sk_test_51PxX77AplPalletsPlaceholderSecretKey'));
        } else {
            Stripe::setApiKey($stripeSecret);
        }

        try {
            // Stripe expects amount in cents
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($total * 100),
                'currency' => 'usd',
                'metadata' => [
                    'email' => session()->get('checkout_shipping.email'),
                    'name' => session()->get('checkout_shipping.name'),
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Process checkout submission.
     */
    public function processPayment(Request $request)
    {
        $cart = session()->get('cart', []);
        $shipping = session()->get('checkout_shipping');

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        if (!$shipping) {
            return redirect()->route('checkout.step1')->with('error', 'Please fill in your shipping details first.');
        }

        $request->validate([
            'payment_method' => 'required|string|in:stripe,bank_wire,cash_app,zelle,usdt,venmo,paypal,cash_on_pickup',
            'payment_intent_id' => 'nullable|string', // set if stripe succeeded
        ]);

        $paymentMethod = $request->payment_method;
        $paymentIntentId = $request->payment_intent_id;
        
        if ($paymentMethod !== 'stripe' && $request->filled('payment_reference')) {
            $paymentIntentId = 'Offline Ref: ' . $request->payment_reference;
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Generate unique order number: APL-YYYYMMDD-XXXX
        $orderNumber = 'APL-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Create the order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => auth()->check() ? auth()->id() : null,
            'email' => $shipping['email'],
            'status' => ($paymentMethod === 'stripe') ? 'processing' : 'pending_payment',
            'payment_method' => $paymentMethod,
            'total' => $total,
            'receiver_info' => $shipping,
            'payment_intent_id' => $paymentIntentId,
        ]);

        // Create order items and decrement stock
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Decrement product stock
            $product = Product::find($item['id']);
            if ($product) {
                $product->stock = max(0, $product->stock - $item['quantity']);
                if ($product->stock === 0) {
                    $product->badge = 'sold_out';
                }
                $product->save();
            }
        }

        // Send email notification to Admin
        try {
            $adminEmail = 'americanpalletliquidators0@gmail.com';
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminNewOrderMail($order));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send admin order notification: ' . $e->getMessage());
        }

        // Send email notification to Customer
        try {
            if (!empty($shipping['email'])) {
                \Illuminate\Support\Facades\Mail::to($shipping['email'])->send(new \App\Mail\CustomerOrderConfirmationMail($order));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send customer order notification: ' . $e->getMessage());
        }

        // Clear checkout session data
        session()->forget('cart');
        session()->forget('checkout_shipping');

        return redirect()->route('checkout.success', $orderNumber)->with('completed_order_id', $order->id);
    }

    /**
     * Order success page.
     */
    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items.product')->firstOrFail();
        
        $settings = [
            'bank_name' => Setting::get('bank_name', 'Chase Bank'),
            'bank_account_name' => Setting::get('bank_account_name', 'American Pallet Liquidators LLC'),
            'bank_routing_number' => Setting::get('bank_routing_number', '123456789'),
            'bank_account_number' => Setting::get('bank_account_number', '9876543210'),
            'cash_app_cashtag' => Setting::get('cash_app_cashtag', '$aplpallets'),
            'zelle_email' => Setting::get('zelle_email', 'zelle@aplpallets.com'),
            'USDT_address' => Setting::get('USDT_address', '0x1234567890abcdef1234567890abcdef12345678'),
            'venmo_handle' => Setting::get('venmo_handle', '@aplpallets'),
            'paypal_email' => Setting::get('paypal_email', 'paypal@aplpallets.com'),
        ];

        return view('checkout.success', compact('order', 'settings'));
    }
}
