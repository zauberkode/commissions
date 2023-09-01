<?php

namespace Commissions\Infrastructure\RateSource;

use Commissions\Application\RateSource;
use Commissions\Application\RequestMaker;

/**
 * Rates from exchangerates api
 */
class ExchangeRates implements RateSource
{
    public function __construct(
        public RequestMaker $requestMaker,
        public string $url
    ) {
    }

    public function getRateForCurrency(string $currency): float
    {
        $rate = 0;
        $json = $this->requestMaker->makeRequest($this->url);
        if ($json && $jsonDecoded = json_decode($json, true)) {
            if (array_key_exists($currency, $jsonDecoded['rates'])) {
                $rate = $jsonDecoded['rates'][$currency];
            }
        } else {
            throw new \Exception("Unable to get the transactions");
        }

        return $rate;
    }
}
