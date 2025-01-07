<?php

namespace BWT\Cache;

interface CacheInterface
{
    public function get(string $key): mixed;

    public function put(string $key, mixed $value): void;
}
