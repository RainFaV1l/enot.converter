<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ConvertRequest;
use App\Http\Resources\V1\CurrencyCollection;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;

class ConvertController extends Controller
{
    private CurrencyRepositoryInterface $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {

        $this->currencyRepository = $currencyRepository;
    }

    public function index(ConvertRequest $request)
    {
        $data = $request->validated();

        $from = $this->currencyRepository->getCurrencyById($data['from']);

        $to = $this->currencyRepository->getCurrencyById($data['to']);

        $fromRate = str_replace(',', '.', $from['VunitRate']);

        $toRate = (float) str_replace(',', '.', $to['VunitRate']);

        $conversionRate = $fromRate / $toRate ;

        $convertedAmount = $data['amount'] * $conversionRate;

        return response()->json(['amount' => $convertedAmount]);
    }
}
