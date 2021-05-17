<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
            ]);
    }
    public function testRepeatPassword()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe1@example.com",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                    "password" => ["The password confirmation does not match."]
            ]);
    }
    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe9@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "user"=>[
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                "token",
                "message"
            ]);
    }
    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
            ]);
    }
    public function testSuccessfulLogin()
    {
        $loginData = ['email' => 'doe8@example.com', 'password' => 'demo12345'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "token",
            ]);
        $this->assertAuthenticated();
    }
    public function testGetAuthenticatedUser()
    {
        $loginData = ['email' => 'doe8@example.com', 'password' => 'demo12345'];

        $response = $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "token",
            ]);

        $this->withHeader('Authorization', 'Bearer ' . $response->json()["token"])->json('GET', 'api/user', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "user"=>[
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
