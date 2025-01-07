<?php

namespace BWT\Tests\Services\Clients\Config;

use BWT\Services\Clients\Configs\ClientConfig;
use PHPUnit\Framework\TestCase;

class ClientConfigTest extends TestCase
{
    public function testGetBaseUri()
    {
        $baseUri = 'https://api.example.com';
        $clientConfig = new ClientConfig($baseUri);
        $this->assertEquals($baseUri, $clientConfig->getBaseUri());
    }
}
