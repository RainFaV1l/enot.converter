<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CurrencyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['@attributes']['ID'],
            'numCode' => $this['NumCode'],
            'charCode' => $this['CharCode'],
            'nominal' => $this['Nominal'],
            'name' => $this['Name'],
            'value' => $this['Value'],
            'vunitRate' => $this['VunitRate'],
        ];
    }
}
