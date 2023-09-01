<?php

namespace Commissions\Domain;

/**
 * A transaction value
 */
class Transaction
{
    public function __construct(
        protected int $bin,
        protected Money $money,
    ) {
    }


    public function getBin(): int
    {
        return $this->bin;
    }


    public function getMoney(): Money
    {
        return $this->money;
    }
}
