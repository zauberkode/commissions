<?php

namespace Commissions\Application;

/**
 * A place to get rate
 */
interface RateSource
{
    public function getRateForCurrency(string $currency): float;
}
