<?php

namespace Commissions\Infrastructure\RequestMaker;

use Commissions\Application\RequestMaker;

/**
 * A functionality to make a request via curl
 */
class CurlRequestMaker implements RequestMaker
{
    private $connection;

    public function __construct(
        protected array $headers,
    ) {
        $this->connection = curl_init();
        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->connection, CURLOPT_HTTPHEADER, $this->headers);
    }

    public function makeRequest($url): ?string
    {
        curl_setopt($this->connection, CURLOPT_URL, $url);
        return curl_exec($this->connection);
    }

    public function __destruct()
    {
        curl_close($this->connection);
    }
}
