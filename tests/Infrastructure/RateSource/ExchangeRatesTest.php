<?php

namespace Commissions\Infrastructure\RateSource;

use Commissions\Application\RequestMaker;
use PHPUnit\Framework\TestCase;

class ExchangeRatesTest extends TestCase
{
    private $sut;

    private $requestMaker;

    protected function setUp(): void
    {
        $this->requestMaker = $this->createStub(RequestMaker::class);
        $this->sut = new ExchangeRates($this->requestMaker, 'someurl');
    }

    public function testGetRateForCurrency(): void
    {
        $this->requestMaker->method('makeRequest')->willReturn(
            '{"rates":{"EUR":1}}'
        );
        $this->assertEquals(1, $this->sut->getRateForCurrency('EUR'));
    }
}
