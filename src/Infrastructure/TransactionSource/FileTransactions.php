<?php

namespace Commissions\Infrastructure\TransactionSource;

use Commissions\Application\Reader;
use Commissions\Application\TransactionSource;
use Commissions\Domain\Money;
use Commissions\Domain\Transaction;

/**
 * Transactions from the file.
 */
class FileTransactions implements TransactionSource
{
    public function __construct(
        protected Reader $reader,
    ) {
    }


    public function provideNext(): ?Transaction
    {
        $line = $this->reader->readNext();
        if ($line && $decoded = json_decode($line)) {
            $money = new Money($decoded->amount, $decoded->currency);
            return new Transaction($decoded->bin, $money);
        }

        return null;
    }
}
