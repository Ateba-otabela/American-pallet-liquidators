<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\FreightQuote;
use Illuminate\Http\Request;

class FreightQuoteController extends Controller
{
    /**
     * Show the freight quote request form.
     */
    public function showForm(Request $request)
    {
        $products = Product::where('stock', '>', 0)->get();
        $selectedProductId = $request->query('product_id');
        $selectedProduct = null;

        if ($selectedProductId) {
            $selectedProduct = Product::find($selectedProductId);
        }

        return view('freight-quote', compact('products', 'selectedProduct', 'selectedProductId'));
    }

    /**
     * Submit the freight quote request form.
     */
    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'destination_zip' => 'required|string|max:10',
            'delivery_type' => 'required|string|in:pickup,delivery',
            'has_loading_dock' => 'nullable|boolean',
            'notes' => 'nullable|string|max:2000',
        ]);

        $validated['has_loading_dock'] = $request->has('has_loading_dock') ? true : false;
        $validated['status'] = 'pending';

        FreightQuote::create($validated);

        return back()->with('success', 'Your freight quote request has been submitted successfully! Our logistics team will calculate the lowest carrier rates and contact you within 1-2 business hours.');
    }
}
