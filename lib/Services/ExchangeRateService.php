<?php

namespace BWT\Services;

use BWT\Adapters\ExchangeRateAdapter;
use BWT\Adapters\ExchangeRateAdapterInterface;
use BWT\Cache\BWTMemcached;
use BWT\Cache\CacheInterface;
use BWT\Values\ExchangeRates;

class ExchangeRateService implements ExchangeRateServiceInterface
{
    public const EXCHANGE_RATES_CACHE_KEY = 'exchange-rate-list';

    public function __construct(
        private ExchangeRateAdapterInterface $exchangeRateAdapter,
        private CacheInterface $cache
    ) {}

    public function getExchangeRates(): ExchangeRates
    {
        if (! $this->cache->get(self::EXCHANGE_RATES_CACHE_KEY)) {
            $this->cache->put(self::EXCHANGE_RATES_CACHE_KEY, $this->exchangeRateAdapter->getLatest());
        }

        return $this->cache->get(self::EXCHANGE_RATES_CACHE_KEY);
    }
}
