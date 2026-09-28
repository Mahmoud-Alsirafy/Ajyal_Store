<?php

namespace App\Helpers;

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
        if ($currency === null) {
            $currency = config('app.currency', 'USD');
        }

        $symbol = static::$symbols[$currency] ?? ($currency . ' ');
        $formatted = number_format((float) $amount, 2);

        return $symbol . $formatted;
    }
}