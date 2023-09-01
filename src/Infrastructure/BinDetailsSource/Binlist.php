<?php

namespace Commissions\Infrastructure\BinDetailsSource;

use Commissions\Application\BinDetailsSource;
use Commissions\Domain\Geography;
use Commissions\Application\RequestMaker;

/**
 * Bin details from binlist
 */
class Binlist implements BinDetailsSource
{
    public function __construct(
        public RequestMaker $requestMaker,
        public Geography $geo,
        public string $url
    ) {
    }

    public function isCardFromEu(int $bin): bool
    {
        $json = $this->requestMaker->makeRequest($this->url . $bin);
        if ($json && $jsonDecoded = json_decode($json)) {
            $country = $jsonDecoded->country->alpha2;
            return in_array($country, $this->geo->getEuCountryCodes());
        } else {
            throw new \Exception("Unable to get the bin details");
        }

        return false;
    }
}
