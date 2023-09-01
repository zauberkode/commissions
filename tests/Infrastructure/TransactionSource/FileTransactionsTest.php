<?php

namespace Commissions\Infrastructure\TransactionSource;

use Commissions\Application\Reader;
use Commissions\Domain\Transaction;
use PHPUnit\Framework\TestCase;

class FileTransactionsTest extends TestCase
{
    private $sut;
    private $reader;

    protected function setUp(): void
    {
        $this->reader = $this->createStub(Reader::class);
        $this->sut = new FileTransactions($this->reader);
    }

    public function testProvidesNextTransaction(): void
    {
        $this->reader->method('readNext')->willReturn(
            '{"bin":"45717360","amount":"100.00","currency":"EUR"}'
        );
        $this->assertInstanceOf(Transaction::class, $this->sut->provideNext());
    }

    public function testDontProvidesNextTransaction(): void
    {
        $this->reader->method('readNext')->willReturn('');
        $this->assertNull($this->sut->provideNext());
    }
}
