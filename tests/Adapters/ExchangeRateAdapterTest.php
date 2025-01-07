<?php

namespace BWT\Tests\Adapters;

use BWT\Adapters\ExchangeRateAdapter;
use BWT\Adapters\ExchangeRateAdapterInterface;
use BWT\Exceptions\ExchangeRateApiException;
use BWT\Mappers\ExchangeRateApiMapperInterface;
use BWT\Services\Clients\ExchangeRateApiClient;
use BWT\Values\ExchangeRates;
use PHPUnit\Framework\TestCase;

class ExchangeRateAdapterTest extends TestCase
{
    private ExchangeRateAdapterInterface $adapter;
    private $mockExchangeRateApiClient;
    private $mockMapper;

    protected function setUp(): void
    {
        $this->mockExchangeRateApiClient = $this->createMock(ExchangeRateApiClient::class);
        $this->mockMapper = $this->createMock(ExchangeRateApiMapperInterface::class);

        $this->adapter = new ExchangeRateAdapter(
            $this->mockExchangeRateApiClient,
            $this->mockMapper
        );
    }

    public function testGetLatestSuccess()
    {
        $apiResponse = [
            'rates' => [
                'USD' => '1.12',
                'EUR' => '0.85',
            ],
        ];
        $expectedExchangeRates = new ExchangeRates();
        $expectedExchangeRates->addRate('USD', 1.12);
        $expectedExchangeRates->addRate('EUR', 0.85);

        // Mock API client response
        $this->mockExchangeRateApiClient
            ->method('get')
            ->with('/latest')
            ->willReturn($apiResponse);

        // Mock mapper response
        $this->mockMapper
            ->method('mapRates')
            ->with($apiResponse)
            ->willReturn($expectedExchangeRates);

        $result = $this->adapter->getLatest();

        // Assertions
        $this->assertInstanceOf(ExchangeRates::class, $result);
        $this->assertSame(1.12, $result->getRate('USD'));
        $this->assertSame(0.85, $result->getRate('EUR'));
    }

    public function testGetLatestApiClientThrowsException()
    {
        // Simulate API client throwing an exception
        $this->mockExchangeRateApiClient
            ->method('get')
            ->with('/latest')
            ->willThrowException(new \RuntimeException('API client error'));

        $this->expectException(ExchangeRateApiException::class);
        $this->expectExceptionMessage('API client error');

        $this->adapter->getLatest();
    }

    public function testGetLatestMapperThrowsException()
    {
        $apiResponse = [
            'rates' => [
                'USD' => '1.12',
                'EUR' => '0.85',
            ],
        ];

        // Mock API client response
        $this->mockExchangeRateApiClient
            ->method('get')
            ->with('/latest')
            ->willReturn($apiResponse);

        // Simulate mapper throwing an exception
        $this->mockMapper
            ->method('mapRates')
            ->with($apiResponse)
            ->willThrowException(new \RuntimeException('Mapping error'));

        $this->expectException(ExchangeRateApiException::class);
        $this->expectExceptionMessage('Mapping error');

        $this->adapter->getLatest();
    }
}
