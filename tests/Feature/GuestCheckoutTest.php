<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class GuestCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_place_order()
    {
        Mail::fake();

        // Create a category and product
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);

        $product = Product::create([
            'name' => 'Test Pallet',
            'slug' => 'test-pallet',
            'description' => 'A test pallet.',
            'price' => 100.00,
            'category_id' => $category->id,
            'stock' => 10,
        ]);

        // Add to cart in session
        $cart = [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ]
        ];

        $this->withSession(['cart' => $cart]);

        // Submit shipping details
        $response = $this->post('/checkout/step1', [
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'zip' => '90210',
        ]);

        $response->assertRedirect('/checkout/payment');
        
        // Assert session has shipping info
        $this->assertEquals('guest@example.com', session('checkout_shipping')['email']);

        // Process payment
        $response = $this->post('/checkout/pay', [
            'payment_method' => 'bank_wire',
        ]);

        // Assert order was created
        $this->assertDatabaseHas('orders', [
            'email' => 'guest@example.com',
            'payment_method' => 'bank_wire',
            'total' => 100.00,
        ]);

        // Assert redirect to success page
        $order = \App\Models\Order::first();
        $response->assertRedirect('/checkout/success/' . $order->order_number);

        // Assert emails were sent
        Mail::assertSent(\App\Mail\AdminNewOrderMail::class);
        Mail::assertSent(\App\Mail\CustomerOrderConfirmationMail::class, function ($mail) {
            return $mail->hasTo('guest@example.com');
        });
    }
}
