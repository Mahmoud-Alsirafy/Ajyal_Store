<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter

{
    private string $apiKey;
    private string $baseUrl = 'https://api.currencyapi.com/v3/latest';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?? (string) config('services.currencyapi.key');
    }

    public function getLatestRates(array $currencies = [])
    {
        $response = Http::get($this->baseUrl, [
            'apikey' => $this->apiKey,
            'currencies' => implode(',', $currencies),
        ]);

        return $response->json();
    }
    public function convert(string $from, string $to, float $amount = 1): float
    {
        $response = Http::get($this->baseUrl, [
            'apikey'        => $this->apiKey,
            'base_currency' => strtoupper($from),
            'currencies'    => strtoupper($to),
        ]);

        $rate = $response->json("data.{$to}.value", 0);

        return $amount * $rate;
    }
}
