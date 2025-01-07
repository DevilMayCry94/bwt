<?php

namespace BWT\Tests\Services\Clients\Config;

use BWT\Services\Clients\Configs\ExchangeRateApiConfig;
use PHPUnit\Framework\TestCase;

class ExchangeRateApiConfigTest extends TestCase
{
    public function testGetBaseUri()
    {
        $baseUri = 'https://api.exchangerateapi.com';
        $exchangeRateApiConfig = new ExchangeRateApiConfig($baseUri, 'dummy-api-key');
        $this->assertEquals($baseUri, $exchangeRateApiConfig->getBaseUri());
    }

    public function testGetApiKey()
    {
        $apiKey = 'dummy-api-key';
        $exchangeRateApiConfig = new ExchangeRateApiConfig('https://api.exchangerateapi.com', $apiKey);
        $this->assertEquals($apiKey, $exchangeRateApiConfig->getApiKey());
    }

    public function testConstructorSetsBaseUri()
    {
        $baseUri = 'https://api.exchangerateapi.com';
        $apiKey = 'dummy-api-key';
        $exchangeRateApiConfig = new ExchangeRateApiConfig($baseUri, $apiKey);
        $this->assertEquals($baseUri, $exchangeRateApiConfig->getBaseUri());
    }
}
