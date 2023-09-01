<?php

namespace Commissions\Infrastructure\BinDetailsSource;

use Commissions\Application\RequestMaker;
use Commissions\Domain\Geography;
use PHPUnit\Framework\TestCase;

class BinlistTest extends TestCase
{
    private $sut;

    private $geo;

    private $requestMaker;

    protected function setUp(): void
    {
        $this->geo = new class extends Geography {
            public static function getEuCountryCode()
            {
                return ['DK'];
            }
        };
        $this->requestMaker = $this->createStub(RequestMaker::class);
        $this->sut = new Binlist($this->requestMaker, $this->geo, 'someurl');
    }

    public function testWhenCardFromEu(): void
    {
        $this->requestMaker->method('makeRequest')->willReturn(
            '{"country":{"alpha2":"DK","name":"Denmark"}}'
        );
        $this->assertTrue($this->sut->isCardFromEu(11111));
    }

    public function testWhenCardIsNotFromEu(): void
    {
        $this->requestMaker->method('makeRequest')->willReturn(
            '{"country":{"alpha2":"US","name":"United States"}}'
        );
        $this->assertFalse($this->sut->isCardFromEu(11111));
    }
}
