<?php

namespace BWT\Services\Clients;

use BWT\Services\Clients\Configs\ClientConfig;
use GuzzleHttp\Client;

abstract class ServiceClient implements HttpClientInterface
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->getClientConfig()->getBaseUri(),
        ]);
    }

    public function get(string $uri, array $params = []): array
    {
        $response = $this->client->get($uri, ['query' => $params]);
        $body = $response->getBody();

        return json_decode($body, true);
    }

    abstract public function getClientConfig(): ClientConfig;
}
