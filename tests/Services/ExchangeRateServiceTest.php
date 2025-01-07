<?php

namespace BWT\Tests\Services;

use BWT\Adapters\ExchangeRateAdapterInterface;
use BWT\Cache\CacheInterface;
use BWT\Exceptions\ExchangeRateApiException;
use BWT\Services\ExchangeRateService;
use BWT\Services\ExchangeRateServiceInterface;
use BWT\Values\ExchangeRates;
use PHPUnit\Framework\TestCase;

class ExchangeRateServiceTest extends TestCase
{
    private ExchangeRateServiceInterface $service;
    private $mockAdapter;
    private $mockCache;

    protected function setUp(): void
    {
        $this->mockAdapter = $this->createMock(ExchangeRateAdapterInterface::class);
        $this->mockCache = $this->createMock(CacheInterface::class);

        $this->service = new ExchangeRateService($this->mockAdapter, $this->mockCache);
    }

    public function testGetExchangeRatesFromCache()
    {
        $cachedRates = new ExchangeRates();
        $cachedRates->addRate('USD', 1.12);
        $cachedRates->addRate('EUR', 0.85);

        // Mock cache behavior to return cached rates
        $this->mockCache
            ->method('get')
            ->with(ExchangeRateService::EXCHANGE_RATES_CACHE_KEY)
            ->willReturn($cachedRates);

        $result = $this->service->getExchangeRates();

        $this->assertInstanceOf(ExchangeRates::class, $result);
        $this->assertSame(1.12, $result->getRate('USD'));
        $this->assertSame(0.85, $result->getRate('EUR'));
    }

    public function testGetExchangeRatesWhenCacheIsEmpty()
    {
        $freshRates = new ExchangeRates();
        $freshRates->addRate('USD', 1.12);
        $freshRates->addRate('EUR', 0.85);

        // Mock cache behavior: no cached value initially
        $this->mockCache
            ->method('get')
            ->with(ExchangeRateService::EXCHANGE_RATES_CACHE_KEY)
            ->willReturnOnConsecutiveCalls(null, $freshRates);

        // Mock adapter behavior to return fresh rates
        $this->mockAdapter
            ->method('getLatest')
            ->willReturn($freshRates);

        // Mock cache put behavior
        $this->mockCache
            ->expects($this->once())
            ->method('put')
            ->with(ExchangeRateService::EXCHANGE_RATES_CACHE_KEY, $freshRates);

        $result = $this->service->getExchangeRates();

        $this->assertInstanceOf(ExchangeRates::class, $result);
        $this->assertSame(1.12, $result->getRate('USD'));
        $this->assertSame(0.85, $result->getRate('EUR'));
    }

    public function testGetExchangeRatesAdapterThrowsException()
    {
        // Mock cache behavior: no cached value initially
        $this->mockCache
            ->method('get')
            ->with(ExchangeRateService::EXCHANGE_RATES_CACHE_KEY)
            ->willReturn(null);

        // Mock adapter behavior to throw an exception
        $this->mockAdapter
            ->method('getLatest')
            ->willThrowException(new ExchangeRateApiException('API error'));

        $this->expectException(ExchangeRateApiException::class);
        $this->expectExceptionMessage('API error');
        $this->service->getExchangeRates();
    }
}
