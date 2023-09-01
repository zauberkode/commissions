<?php

namespace Commissions\Application;

/**
 * Read some resource string by string
 */
interface Reader
{
    public function readNext(): string;
}
