<?php

namespace BWT\Cache;

use BWT\Core\Config;

class BWTMemcached implements CacheInterface
{
    private static BWTMemcached $instance;
    private \Memcached $memcached;

    protected function __construct()
    {
        $this->memcached = new \Memcached();
        $this->memcached->addServer(Config::get('memcached.host'), (int) Config::get('memcached.port'));
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function get(string $key): mixed
    {
        return $this->memcached->get($key);
    }

    public function put(string $key, mixed $value): void
    {
        $this->memcached->add($key, $value);
    }
}
