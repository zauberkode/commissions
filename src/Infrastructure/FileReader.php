<?php

namespace Commissions\Infrastructure;

use Commissions\Application\Reader;

/**
 * A functionality to read a file line by line
 */
class FileReader implements Reader
{
    private $hander;

    public function __construct(
        protected string $path,
    ) {
        $this->handler = fopen($path, 'r');
    }


    public function readNext(): string
    {
        if ($line = fgets($this->handler)) {
            return $line;
        }

        return '';
    }


    public function __destruct()
    {
        fclose($this->handler);
    }
}
