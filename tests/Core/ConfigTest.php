<?php

namespace BWT\Tests\Core;

use BWT\Core\Config;
use BWT\Exceptions\ConfigNotFoundException;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        if (!defined('BASE_DIR')) {
            define('BASE_DIR', __DIR__.'/../mocks/configs');
        }
    }

    public function testGetReturnsNestedValue()
    {
        $this->assertSame('memcached', Config::get('memcached.host'));
        $this->assertSame(11211, Config::get('memcached.port'));
    }

    public function testThrowsExceptionIfConfigNotFound()
    {
        $this->expectException(ConfigNotFoundException::class);
        Config::get('memcached.invalid_key');
    }
}
