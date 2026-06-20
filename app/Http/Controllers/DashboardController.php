<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Mail\AdminPaymentSubmittedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('orders'));
    }

    /**
     * Handle payment proof submission.
     */
    public function completePayment(Request $request, Order $order)
    {
        // Security check: Make sure this order belongs to the logged-in user!
        if ($order->user_id !== auth()->id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        // Validate submission
        $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'transaction_screenshot' => 'required|image|max:10240', // Max 10MB
        ]);

        // Store screenshot in public screenshots directory
        if ($request->hasFile('transaction_screenshot')) {
            $path = $request->file('transaction_screenshot')->store('screenshots', 'public');
            $order->transaction_screenshot = '/storage/' . $path;
        }

        $order->transaction_reference = $request->transaction_reference;
        $order->save();

        // Send email to admin notifying about payment proof
        try {
            $adminEmail = Setting::get('contact_email', 'americanpalletliquidators0@gmail.com');
            Mail::to($adminEmail)->send(new AdminPaymentSubmittedMail($order));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send payment proof email to admin: ' . $e->getMessage());
        }

        // If AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment details submitted successfully.'
            ]);
        }

        return back()->with('success', 'Payment details submitted successfully. We are checking the payment.');
    }
}
