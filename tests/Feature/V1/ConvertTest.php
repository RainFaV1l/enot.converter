<?php

namespace Feature\V1;

use Tests\TestCase;

class ConvertTest extends TestCase
{
    private string $bearerToken = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE3MjE3Mzc3MTEsImV4cCI6MTcyMTc0MTMxMSwibmJmIjoxNzIxNzM3NzExLCJqdGkiOiJndlM5c1dVZ2VOZmVzRHVJIiwic3ViIjoiMSIsInBydiI6ImM4YmYxNWU1ODI4ZTZmMGZiMmU4MjYzNTE5Y2VkODhjZjhlZjI0MGYifQ.zDi_wE502zdirkn03-tl1Sp4iKzv3XvvsrNab_oexvA';

    public function test_store_api_without_bearer_token(): void
    {
        $response = $this->postJson('/api/v1/convert', [
            'to' => 'R01100',
            'from' => 'R01115',
            'amount' => '100',
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    public function test_store_api(): void
    {
        $response = $this->postJson('/api/v1/convert', [
            'to' => 'R01100',
            'from' => 'R01115',
            'amount' => '100',
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->bearerToken
        ]);

        $response->assertStatus(200);
    }
}
