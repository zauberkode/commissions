<?php

namespace Commissions\Application;

use Commissions\Domain\CommissionCalculation;
use Commissions\Domain\Money;
use Commissions\Domain\Transaction;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    private Application $app;

    private TransactionSource $transactions;

    private BinDetailsSource $binDetails;

    private RateSource $rates;

    private CommissionCalculation $calc;

    protected function setUp(): void
    {
        $this->transactions = $this->createMock(TransactionSource::class);
        $this->binDetails = $this->createStub(BinDetailsSource::class);
        $this->rates = $this->createStub(RateSource::class);
        $this->calc = $this->createStub(CommissionCalculation::class);

        $this->app = new Application(
            $this->transactions,
            $this->binDetails,
            $this->rates,
            $this->calc
        );
    }

    public function testWhenNoTransactions()
    {
        $this->transactions->method("provideNext")->willReturn(null);
        $expected = "";
        $this->expectOutputString($expected);
        $this->app->run();
    }

    public function testWhenTransactionProvided()
    {
        $money = $this->createStub(Money::class);
        $money->method('getAmount')->willReturn(50.0);
        $money->method('getCurrency')->willReturn('USD');

        $transaction = $this->createStub(Transaction::class);
        $transaction->method('getBin')->willReturn(516793);
        $transaction->method('getMoney')->willReturn($money);

        $this->transactions->expects($this->atLeastOnce())
                           ->method("provideNext")
                           ->willReturnOnConsecutiveCalls(
                               $transaction,
                               null
                           );
        $this->rates->method("getRateForCurrency")->willReturn(5.0);
        $this->binDetails->method("isCardFromEu")->willReturn(true);

        $this->calc->method('do')->willReturn(2);

        $this->expectOutputString("2\n");
        $this->app->run();
    }
}
