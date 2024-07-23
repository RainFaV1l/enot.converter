<?php

namespace Feature\V1;

use Tests\TestCase;

class CurrenciesTest extends TestCase
{
    private string $bearerToken = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE3MjE3Mzc3MTEsImV4cCI6MTcyMTc0MTMxMSwibmJmIjoxNzIxNzM3NzExLCJqdGkiOiJndlM5c1dVZ2VOZmVzRHVJIiwic3ViIjoiMSIsInBydiI6ImM4YmYxNWU1ODI4ZTZmMGZiMmU4MjYzNTE5Y2VkODhjZjhlZjI0MGYifQ.zDi_wE502zdirkn03-tl1Sp4iKzv3XvvsrNab_oexvA';

    public function test_currencies_api_without_bearer_token(): void
    {
        $response = $this->get('/api/v1/currencies', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    public function test_currencies_api(): void
    {
        $response = $this->get('/api/v1/currencies', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->bearerToken
        ]);

        $response->assertStatus(200);
    }

    public function test_one_currency_api_without_bearer_token(): void
    {
        $response = $this->get('/api/v1/currencies/R01010', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    public function test_one_currency_api(): void
    {
        $response = $this->get('/api/v1/currencies/R01010', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->bearerToken
        ]);

        $response->assertStatus(200);
    }
}
