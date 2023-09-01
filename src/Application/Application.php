<?php

namespace Commissions\Application;

use Commissions\Domain\CommissionCalculation;

/**
 * The application to read transactions, calculate commissions and echo them
 */
class Application
{
    public function __construct(
        protected TransactionSource $transactionsProvider,
        protected BinDetailsSource $cardsProvider,
        protected RateSource $rates,
        protected CommissionCalculation $calculation
    ) {
    }

    public function run()
    {
        while ($transaction = $this->transactionsProvider->provideNext()) {
            $currency = $transaction->getMoney()->getCurrency();
            $rate = $this->rates->getRateForCurrency($currency);
            $isCardFromEu = $this->cardsProvider->isCardFromEu($transaction->getBin());
            $commission = $this->calculation->do($transaction, $rate, $isCardFromEu);
            echo $commission , "\n";
        }
    }
}
