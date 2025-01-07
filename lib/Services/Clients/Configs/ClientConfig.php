<?php

namespace BWT\Services\Clients\Configs;

class ClientConfig
{
    public function __construct(
        private string $baseUri
    ) {}

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}
