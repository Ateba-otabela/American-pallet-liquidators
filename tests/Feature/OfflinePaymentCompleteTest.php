<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Mail\AdminPaymentSubmittedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OfflinePaymentCompleteTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;
    protected $category;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard user
        $this->user = User::factory()->create([
            'is_admin' => false,
        ]);

        // Create admin user
        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);

        // Create category and product
        $this->category = Category::create([
            'name' => 'General Pallets',
            'slug' => 'general-pallets',
        ]);

        $this->product = Product::create([
            'name' => 'Target Pallet Lot',
            'slug' => 'target-pallet-lot',
            'description' => 'Target overstock merchandise.',
            'price' => 500.00,
            'category_id' => $this->category->id,
            'stock' => 10,
            'images' => ['https://placehold.co/600x600?text=Target+Lot'],
        ]);
    }

    /**
     * Test guest is redirected to login from checkout.
     */
    public function test_guest_is_redirected_to_login_from_checkout()
    {
        $response = $this->get(route('checkout.step1'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test registration during checkout intended flow redirects back to checkout.
     */
    public function test_registration_with_intended_url_redirects_to_checkout()
    {
        // Simulate visiting checkout first to set intended URL in session
        $this->get(route('checkout.step1'));

        $response = $this->post('/register', [
            'name' => 'New Merchant',
            'email' => 'newmerchant@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        // Registration store should redirect to checkout because of intended redirect
        $response->assertRedirect(route('checkout.step1'));
    }

    /**
     * Test authenticated merchant can view dashboard and pending orders.
     */
    public function test_merchant_can_view_dashboard_with_orders()
    {
        // Create an order for the user
        $order = Order::create([
            'order_number' => 'APL-20260520-TEST',
            'user_id' => $this->user->id,
            'status' => 'pending_payment',
            'payment_method' => 'bank_wire',
            'total' => 500.00,
            'receiver_info' => [
                'name' => 'Test Merchant',
                'email' => 'testmerchant@example.com',
                'phone' => '1234567890',
                'address' => '123 Test St',
                'city' => 'Louisville',
                'state' => 'KY',
                'zip' => '40201'
            ],
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('APL-20260520-TEST');
        $response->assertSee('Pending Payment');
        $response->assertSee('Complete Order');
    }

    /**
     * Test customer can submit transaction payment proof.
     */
    public function test_customer_can_submit_payment_proof()
    {
        Mail::fake();
        Storage::fake('public');

        $order = Order::create([
            'order_number' => 'APL-20260520-TEST',
            'user_id' => $this->user->id,
            'status' => 'pending_payment',
            'payment_method' => 'zelle',
            'total' => 500.00,
            'receiver_info' => [
                'name' => 'Test Merchant',
                'email' => 'testmerchant@example.com',
                'phone' => '1234567890',
                'address' => '123 Test St',
                'city' => 'Louisville',
                'state' => 'KY',
                'zip' => '40201'
            ],
        ]);

        $screenshot = UploadedFile::fake()->create('receipt.png', 100, 'image/png');

        $response = $this->actingAs($this->user)
            ->post(route('orders.complete-payment', $order), [
                'transaction_reference' => 'ZELLE-REF-998877',
                'transaction_screenshot' => $screenshot,
            ], [
                'HTTP_X-Requested-With' => 'XMLHttpRequest' // AJAX simulation
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Payment details submitted successfully.'
        ]);

        // Assert details saved in database
        $order->refresh();
        $this->assertEquals('ZELLE-REF-998877', $order->transaction_reference);
        $this->assertNotNull($order->transaction_screenshot);
        $this->assertStringContainsString('/storage/screenshots/', $order->transaction_screenshot);

        // Assert screenshot is stored in storage
        Storage::disk('public')->assertExists(str_replace('/storage/', '', $order->transaction_screenshot));

        // Assert email notification is sent to admin
        Mail::assertSent(AdminPaymentSubmittedMail::class, function ($mail) use ($order) {
            return $mail->order->id === $order->id &&
                   $mail->hasTo('americanpalletliquidators0@gmail.com');
        });
    }

    /**
     * Test other users cannot submit proof for a different user's order.
     */
    public function test_other_user_cannot_submit_proof_for_different_order()
    {
        $otherUser = User::factory()->create();

        $order = Order::create([
            'order_number' => 'APL-20260520-TEST',
            'user_id' => $this->user->id,
            'status' => 'pending_payment',
            'payment_method' => 'zelle',
            'total' => 500.00,
            'receiver_info' => [
                'name' => 'Test Merchant',
                'email' => 'testmerchant@example.com',
                'phone' => '1234567890',
                'address' => '123 Test St',
                'city' => 'Louisville',
                'state' => 'KY',
                'zip' => '40201'
            ],
        ]);

        $screenshot = UploadedFile::fake()->create('receipt.png', 100, 'image/png');

        $response = $this->actingAs($otherUser)
            ->post(route('orders.complete-payment', $order), [
                'transaction_reference' => 'HACKED-REF',
                'transaction_screenshot' => $screenshot,
            ]);

        $response->assertStatus(403);
    }

    /**
     * Test admin can view order and transaction proof details.
     */
    public function test_admin_can_view_submitted_proof_in_admin_panel()
    {
        $order = Order::create([
            'order_number' => 'APL-20260520-TEST',
            'user_id' => $this->user->id,
            'status' => 'pending_payment',
            'payment_method' => 'zelle',
            'total' => 500.00,
            'receiver_info' => [
                'name' => 'Test Merchant',
                'email' => 'testmerchant@example.com',
                'phone' => '1234567890',
                'address' => '123 Test St',
                'city' => 'Louisville',
                'state' => 'KY',
                'zip' => '40201'
            ],
            'transaction_reference' => 'ZELLE-12345',
            'transaction_screenshot' => '/storage/screenshots/receipt.png'
        ]);

        // Admin visits the admin order details page
        $response = $this->actingAs($this->admin)->get(route('admin.orders.show', $order));

        $response->assertStatus(200);
        $response->assertSee('Payment Submitted for Review');
        $response->assertSee('ZELLE-12345');
        $response->assertSee('/storage/screenshots/receipt.png');
    }
}
