<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CurrencyCollection;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class CurrencyController extends Controller
{
    private CurrencyRepositoryInterface $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index()
    {

        $currencies = $this->currencyRepository->getAllCurrencies();

        if($currencies) {

            $data = collect($currencies);

            return CurrencyCollection::collection($data);

        }

        Log::error('Ошибка при получении ответа из внешнего api');

        return response()->json(['error' => 'Не удалось получить данные из api'], 502);

    }

    public function show($id)
    {

        $currency = $this->currencyRepository->getCurrencyById($id);

        if($currency) {

            $data = collect($currency);

            return new CurrencyCollection($data);

        }

        return response()->json(['error' => 'Не удалось получить данные из api'], 502);

    }
}
