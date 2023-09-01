<?php

namespace Commissions\Domain;

/**
 * Money value
 */
class Money
{
    public function __construct(
        public float $amount,
        public string $currency,
    ) {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
