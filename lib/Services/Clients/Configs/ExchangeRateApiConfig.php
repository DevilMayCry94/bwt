<?php

namespace BWT\Services\Clients\Configs;

class ExchangeRateApiConfig extends ClientConfig
{
    public function __construct(
        private string $baseUri,
        private string $apiKey,
    ) {
        parent::__construct($this->baseUri);
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
