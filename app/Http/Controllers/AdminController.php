<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Show Admin Dashboard metrics and stats.
     */
    public function dashboard()
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total');
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 3)->get();
        
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalSales', 'ordersCount', 'productsCount', 'lowStockProducts', 'recentOrders'));
    }

    /**
     * List all products for inventory management.
     */
    public function products()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show form to create a new product.
     */
    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|in:sale,sold_out',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:5120',
        ]);

        $slug = Str::slug($request->name);
        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $images = [];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $images[] = '/storage/' . $path;
        } else {
            $images[] = 'https://placehold.co/600x600?text=' . urlencode($request->name);
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'badge' => $request->badge,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'images' => $images,
        ]);

        // Notify all subscribers about the new wholesale lot
        try {
            $subscribers = \App\Models\Subscriber::all();
            foreach ($subscribers as $subscriber) {
                try {
                    \Illuminate\Support\Facades\Mail::to($subscriber->email)->send(new \App\Mail\NewProductNotificationMail($product));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send product notification to subscriber ' . $subscriber->email . ': ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to notify subscribers about new product: ' . $e->getMessage());
        }

        return redirect()->route('admin.products')->with('success', 'Product created successfully and subscribers notified!');
    }

    /**
     * Show form to edit a product.
     */
    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product details.
     */
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|in:sale,sold_out',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:5120',
        ]);

        $images = $product->images;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $images = ['/storage/' . $path];
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'badge' => $request->badge,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'images' => $images,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete a product.
     */
    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    /**
     * List all orders.
     */
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show details of a specific order.
     */
    public function showOrder(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending_payment,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:255',
            'tracking_url' => 'nullable|string|max:255',
        ]);

        $originalStatus = $order->status;
        $newStatus = $request->status;

        // Require a tracking number if changing to processing or shipped
        if (in_array($newStatus, ['processing', 'shipped'])) {
            if (!$request->filled('tracking_number') && empty($order->tracking_number)) {
                return back()->with('error', 'You must provide a Tracking Number on the Manage Order page before changing the status to Processing or Shipped.');
            }
        }

        $trackingNumber = $request->filled('tracking_number') ? $request->tracking_number : $order->tracking_number;
        
        $trackingUrl = $request->tracking_url;
        if ($request->filled('tracking_url')) {
            if (!str_starts_with($trackingUrl, 'http://') && !str_starts_with($trackingUrl, 'https://')) {
                $trackingUrl = 'https://' . $trackingUrl;
            }
        } else {
            $trackingUrl = $order->tracking_url;
        }

        $order->update([
            'status' => $newStatus,
            'tracking_number' => $trackingNumber,
            'tracking_url' => $trackingUrl,
        ]);

        // If status changed to processing/shipped OR tracking details were updated, send/resend email
        $statusChanged = $originalStatus !== $newStatus;
        $trackingUpdated = $order->wasChanged('tracking_number') && !empty($order->tracking_number);

        if (($statusChanged || $trackingUpdated) && in_array($newStatus, ['processing', 'shipped'])) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->receiver_info['email'])->send(new \App\Mail\OrderProcessedMail($order));
            } catch (\Exception $e) {
                // Log the email failure but don't stop the status update
                \Illuminate\Support\Facades\Log::error('Failed to send order processed email: ' . $e->getMessage());
                return back()->with('success', 'Order status updated successfully, but the email failed to send (Check SMTP config).');
            }
        }

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Show general and payment settings form.
     */
    public function settings()
    {
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
            'stripe_secret_key' => Setting::get('stripe_secret_key', 'sk_test_placeholder'),
            'contact_email' => Setting::get('contact_email', 'Brett@bidonpallets.com'),
            'contact_phone' => Setting::get('contact_phone', '(502) 208-1035'),
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Save settings.
     */
    public function updateSettings(Request $request)
    {
        $keys = [
            'bank_name', 'bank_account_name', 'bank_routing_number', 'bank_account_number',
            'cash_app_cashtag', 'zelle_email', 'USDT_address', 'venmo_handle', 'paypal_email',
            'stripe_publishable_key', 'stripe_secret_key', 'contact_email', 'contact_phone'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Display visitor analytics telemetry logs.
     */
    public function visitLogs()
    {
        $logs = \App\Models\VisitLog::latest()->paginate(50);
        
        // Calculate simple metrics for dashboard blocks
        $totalVisits = \App\Models\VisitLog::count();
        $mobileVisits = \App\Models\VisitLog::where('device_type', 'Mobile')->count();
        $tabletVisits = \App\Models\VisitLog::where('device_type', 'Tablet')->count();
        $desktopVisits = \App\Models\VisitLog::where('device_type', 'Desktop')->count();
        $uniqueIPs = \App\Models\VisitLog::distinct('ip_address')->count('ip_address');

        return view('admin.logs.index', compact('logs', 'totalVisits', 'mobileVisits', 'tabletVisits', 'desktopVisits', 'uniqueIPs'));
    }

    /**
     * Clear all visit logs from database.
     */
    public function clearVisitLogs()
    {
        \App\Models\VisitLog::truncate();
        return back()->with('success', 'Visitor analytics logs cleared successfully.');
    }
}
