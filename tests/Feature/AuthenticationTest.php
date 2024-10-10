<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_screen_rendered_successful(){
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Email');
        $response->assertSee('Password');
    }

    public function test_user_can_authenticate_using_login_page(){
        $user = User::factory()->create([
            "email" => "admin@example.com",
            "password" => "password"
        ]);

        $response = $this->post('/login', [
            "email" => $user->email,
            "password" => "password"
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_cannot_authenticate_with_invalid_password(){
        $user = User::factory()->create([
            "email" => "admin@example.com",
            "password" => "password"
        ]);

        $response = $this->post('/login', [
            "email" => $user->email,
            "password" => "password123"
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
