<?php

namespace App\Services\PriceRateConvertor;

use App\Models\CurrencyRate;

class PriceRateConvertor
{
    public function convertToCurrency(float $price, string $currency):int|float
    {
        $rate=CurrencyRate::query()->where('currency',$currency)->value('rate');
        return $price * $rate;
    }
}
