<?php

namespace Commissions\Domain;

/**
 * A transaction commission calculation algorithm
 */
class CommissionCalculation
{
    public function do(Transaction $transaction, float $rate, bool $isCardFromEu)
    {
        $money = $transaction->getMoney();
        $amount = $money->getAmount();
        if ($money->getCurrency() != 'EUR' || $rate > 0) {
            $amount /= $rate;
        }

        if ($isCardFromEu) {
            $amount *= 0.01;
        } else {
            $amount *= 0.02;
        }

        $mult = pow(10, 2);

        return ceil($amount * $mult) / $mult;
    }
}
