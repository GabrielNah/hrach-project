<?php

namespace App\Services\PriceRateConvertor;

use App\Models\CurrencyRate;

class PriceRateConvertor
{
    public function convertToCurrency(int $price, string $currency):int
    {
        $rate=CurrencyRate::query()->where('currency',$currency)->value('rate');
        return $price * $rate;
    }
}
