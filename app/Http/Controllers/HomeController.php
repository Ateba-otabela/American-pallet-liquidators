<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->orderBy('id', 'asc')
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts'));
    }

    /**
     * Display How It Works.
     */
    public function howItWorks()
    {
        return view('how-it-works');
    }

    /**
     * Display Sell to Us.
     */
    public function sellToUs()
    {
        return view('sell-to-us');
    }

    /**
     * Display FAQ.
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Display Contact Us page.
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Handle Contact Form submission.
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        // In a real application, you would send an email or store this in database.
        // For the design study, we show a success notification.
        return back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you shortly.');
    }

    /**
     * Handle email subscription.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:subscribers,email',
        ], [
            'email.unique' => 'This email is already subscribed!',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        return back()->with('subscribed', 'Thank you for subscribing to our liquidated merchandise alerts!');
    }
}
