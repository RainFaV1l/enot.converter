<?php

namespace Feature\V1;

use Tests\TestCase;

class AuthTest extends TestCase
{
    private string $bearerToken = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE3MjE3Mzc3MTEsImV4cCI6MTcyMTc0MTMxMSwibmJmIjoxNzIxNzM3NzExLCJqdGkiOiJndlM5c1dVZ2VOZmVzRHVJIiwic3ViIjoiMSIsInBydiI6ImM4YmYxNWU1ODI4ZTZmMGZiMmU4MjYzNTE5Y2VkODhjZjhlZjI0MGYifQ.zDi_wE502zdirkn03-tl1Sp4iKzv3XvvsrNab_oexvA';

    public function test_register_api(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Alex',
            'surname' => 'Redfild',
            'email' => 'alex-redfild7@example.com',
            'password' => 'Test1:)',
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_api(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'alex-redfild@example.com',
            'password' => 'Test1:)',
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);
    }

    public function test_logout_api_without_bearer(): void
    {
        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    public function test_logout_api(): void
    {
        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->bearerToken
        ]);

        $response->assertStatus(200);
    }

    public function test_refresh_api(): void
    {
        $response = $this->postJson('/api/v1/auth/refresh', [], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->bearerToken
        ]);

        $response->assertStatus(200);
    }

    public function test_user_api_without_bearer(): void
    {
        $response = $this->get('/api/v1/auth/user', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    public function test_user_api(): void
    {
        $response = $this->get('/api/v1/auth/user', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->bearerToken
        ]);

        $response->assertStatus(200);
    }
}
