<?php

namespace Commissions\Application;

use Commissions\Domain\Transaction;

/**
 * A place to get transactions
 */
interface TransactionSource
{
    public function provideNext(): ?Transaction;
}
