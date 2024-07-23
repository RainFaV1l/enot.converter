<?php

namespace App\Repositories\V1;

use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyRepository implements CurrencyRepositoryInterface
{

    private const CACHE_TTL = 1440;

    /**
     * @param string $url
     * @return \SimpleXMLElement|null
     */
    public function fetchXmlData(string $url): null|\SimpleXMLElement
    {
        $response = Http::get($url);

        if ($response->successful()) {

            $body = $response->body();

            $xml = simplexml_load_string($body);

            if ($xml === false) {
                return null;
            }

            return $xml;
        }

        return null;
    }

    public function parseCurrencies(\SimpleXMLElement $xml): array
    {
        $currencies = [];

        foreach ($xml->Valute as $valute) {

            $json = json_encode($valute);

            $currencies[] = json_decode($json, true);

        }

        return $currencies;
    }


    /**
     * @return array|null
     */
    public function getAllCurrencies(): array | null
    {
        return Cache::remember('currencies', self::CACHE_TTL, function () {

            $xml = $this->fetchXmlData('https://www.cbr.ru/scripts/XML_daily.asp');

            if ($xml === false) {

                Log::error('Ошибка при парсинге XML', ['response' => $xml]);

                return null;
            }

            return $this->parseCurrencies($xml);

        });
    }



    public function getCurrencyById(string $id): mixed
    {
        $currencies = $this->getAllCurrencies();

        if ($currencies) {

            foreach ($currencies as $currency) {

                if ($currency['@attributes']['ID'] === $id) {
                    return $currency;
                }

            }
        }

        return null;
    }
}
