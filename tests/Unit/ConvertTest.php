<?php

namespace Tests\Unit;

use App\Http\Controllers\V1\ConvertController;
use App\Http\Requests\V1\ConvertRequest;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\TestCase;

class ConvertTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_converted_amount(): void
    {
        $currencyRepository = \Mockery::mock(CurrencyRepositoryInterface::class);

        $currencyRepository->shouldReceive('getCurrencyById')
            ->with('R01100')
            ->andReturn(['VunitRate' => '48,8758']);

        $currencyRepository->shouldReceive('getCurrencyById')
            ->with('R01115')
            ->andReturn(['VunitRate' => '15,8049']);

        $controller = new ConvertController($currencyRepository);

        $request = ConvertRequest::create('/convert', 'POST', [
            'to' => 'R01100',
            'from' => 'R01115',
            'amount' => 100
        ]);

        $response = $controller->storeTest($request->all());

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(32.336862005327795, $response->getData()->amount);

    }
}
