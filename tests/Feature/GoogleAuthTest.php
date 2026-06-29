<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;
use Mockery;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_redirect_works()
    {
        $response = $this->get('/auth/google/redirect');
        
        // Assert it redirects to Google (or somewhere)
        $response->assertStatus(302);
    }

    public function test_google_callback_creates_user_and_logs_in()
    {
        // Mock the Socialite User object
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')
            ->andReturn('1234567890')
            ->shouldReceive('getName')
            ->andReturn('Test Google User')
            ->shouldReceive('getEmail')
            ->andReturn('testgoogle@example.com')
            ->shouldReceive('getNickname')
            ->andReturn(null);

        // Mock the Socialite Driver
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('stateless')->andReturn($provider);
        $provider->shouldReceive('user')->andReturn($abstractUser);

        // Bind the mock driver to Socialite
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Call the callback route
        $response = $this->get('/auth/google/callback');

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'email' => 'testgoogle@example.com',
            'google_id' => '1234567890',
        ]);

        // Assert user is authenticated
        $this->assertAuthenticated();

        // Assert it redirects to the home page (or dashboard)
        $response->assertRedirect(route('home', absolute: false));
    }
}
