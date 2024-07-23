<?php

namespace App\Repositories\Interfaces;

interface CurrencyRepositoryInterface
{
    /**
     * @param string $url
     * @return \SimpleXMLElement|null
     */
    public function fetchXmlData(string $url): null|\SimpleXMLElement;

    /**
     * @param \SimpleXMLElement $xml
     * @return array
     */
    public function parseCurrencies(\SimpleXMLElement $xml): array;

    /**
     * @return array|null
     */
    public function getAllCurrencies(): array | null;


    /**
     * @param string $id
     * @return mixed
     */
    public function getCurrencyById(string $id): mixed;
}
