<?php

namespace Commissions\Domain;

use PHPUnit\Framework\TestCase;

class CommissionCalculationTest extends TestCase
{
    private $sut;

    protected function setUp(): void
    {
        $this->sut = new CommissionCalculation();
    }

    public function testWhenCardFromEu(): void
    {
        $money = $this->createStub(Money::class);
        $money->method('getAmount')->willReturn(50.0);
        $money->method('getCurrency')->willReturn('USD');

        $transaction = $this->createStub(Transaction::class);
        $transaction->method('getBin')->willReturn(516793);
        $transaction->method('getMoney')->willReturn($money);

        $rate = 0.813399;
        $isCardFromEu = true;
        $this->assertEquals(0.62, $this->sut->do($transaction, $rate, $isCardFromEu));
    }

    public function testWhenCardNotFromEu(): void
    {
        $money = $this->createStub(Money::class);
        $money->method('getAmount')->willReturn(50.0);
        $money->method('getCurrency')->willReturn('USD');

        $transaction = $this->createStub(Transaction::class);
        $transaction->method('getBin')->willReturn(516793);
        $transaction->method('getMoney')->willReturn($money);

        $rate = 0.813399;
        $isCardFromEu = false;
        $this->assertEquals(1.23, $this->sut->do($transaction, $rate, $isCardFromEu));
    }
}
