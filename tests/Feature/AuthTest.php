<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Test User Registers Successfully
     */
    public function test_user_registers_successfully(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password'
        ];

        $response = $this->postJson(route('auth.register'),$userData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);

        $response->assertJsonFragment([
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    public function test_user_logins_successfully(): void
    {
        /*
         * form validation
         * insert user data into db
         * check if user exists in db
         * check if user is valid
         * creates a token
         * return the token return response 200
         */
        $response = $this->postJson(route('auth.login'),[
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => $this->user->name,
            'email' => $this->user->email
        ]);
    }

    public function test_login_fails_with__wrong_password(): void
    {
        $response = $this->postJson(route('auth.login'),[
            'email' => $this->user->email,
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(401);
    }
}
