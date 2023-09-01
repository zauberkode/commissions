<?php

namespace Commissions\Application;

/**
 * A place to get the info about the bin
 */
interface BinDetailsSource
{
    public function isCardFromEu(int $bin): bool;
}
