<?php

namespace BWT\Services\Clients;

use BWT\Services\Clients\Configs\ExchangeRateApiConfig;
use GuzzleHttp\Client;

class ExchangeRateApiClient implements HttpClientInterface
{
    private Client $client;
    private ExchangeRateApiConfig $config;

    public function __construct()
    {
        $this->config = new ExchangeRateApiConfig(
            appconfig('rate_exchange_api.base_url'),
            appconfig('rate_exchange_api.api_key')
        );

        $this->client = new Client([
           'base_uri' => $this->config->getBaseUri(),
       ]);
    }

    public function get(string $uri, array $params = []): array
    {
        $response = $this->client->get(
            $uri,
            [
                'query' => [...$params, 'access_key' => $this->config->getApiKey()],
            ]
        );
        $body = $response->getBody();

        return json_decode($body, true);
    }
}
