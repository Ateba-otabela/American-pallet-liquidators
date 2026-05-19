<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * View the shopping cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->get('quantity', 1);

        if ($product->badge === 'sold_out' || $product->stock <= 0) {
            return back()->with('error', 'Sorry, this product is currently sold out.');
        }

        if ($quantity <= 0) {
            $quantity = 1;
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            // Check stock limit
            if ($newQuantity > $product->stock) {
                return back()->with('error', "Only {$product->stock} unit(s) available in stock. You already have " . $cart[$product->id]['quantity'] . " in your cart.");
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            // Check stock limit
            if ($quantity > $product->stock) {
                return back()->with('error', "Only {$product->stock} unit(s) available in stock.");
            }

            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $quantity,
                'image' => $product->first_image_url,
                'slug' => $product->slug,
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', "{$product->name} added to cart successfully!");
    }

    /**
     * Update quantity of a product in the cart.
     */
    public function update(Request $request, Product $product)
    {
        $quantity = (int) $request->get('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($product);
        }

        // Validate stock
        if ($quantity > $product->stock) {
            return back()->with('error', "Only {$product->stock} unit(s) available in stock.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
