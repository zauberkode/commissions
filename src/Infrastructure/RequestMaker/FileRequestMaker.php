<?php

namespace Commissions\Infrastructure\RequestMaker;

use Commissions\Application\RequestMaker;

/**
 * A functionality to make a request to a file or an url
 */
class FileRequestMaker implements RequestMaker
{
    public function makeRequest($url): ?string
    {
        return file_get_contents($url);
    }
}
