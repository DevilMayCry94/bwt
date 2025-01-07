<?php
namespace BWT\Services\Clients;

interface HttpClientInterface
{
    /**
     * @param array<string, mixed> $params
     */
    public function get(string $uri, array $params = []): array;
}
