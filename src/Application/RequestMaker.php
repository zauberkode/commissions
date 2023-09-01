<?php

namespace Commissions\Application;

/**
 * A functionality to make a request to an url
 */
interface RequestMaker
{
    public function makeRequest(string $url): ?string;
}
