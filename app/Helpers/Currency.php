<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Currency
{
    // Map of currency codes to their symbols
    protected static array $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'SAR' => 'SAR ',
        'AED' => 'AED ',
        'KWD' => 'KWD ',
        'EGP' => 'EGP ',
        'JOD' => 'JOD ',
        'QAR' => 'QAR ',
        'BHD' => 'BHD ',
        'OMR' => 'OMR ',
    ];

    public static function format($amount, $currency = null): string
    {
        $baseCurrency = config('app.currency', 'USD');
        if ($currency === null) {
            $currency = Session::get('currency_code') ?? $baseCurrency;
        }

        $symbol = static::$symbols[$currency] ?? ($currency . ' ');

        if ($currency != $baseCurrency) {
            $rate = Cache::get('currency_rate_' . $currency, 1);
            $amount = $amount * $rate;
        }
        $formatted = number_format((float) $amount, 2);

        return $symbol . $formatted;
    }
}