<?php

namespace BWT\Tests\Services;

use BWT\Adapters\BinListAdapterInterface;
use BWT\Services\CommissionService;
use BWT\Services\CommissionServiceInterface;
use BWT\Services\ExchangeRateServiceInterface;
use BWT\Values\Account;
use BWT\Values\BinDetails;
use BWT\Values\ExchangeRates;
use PHPUnit\Framework\MockObject\IncompatibleReturnValueException;
use PHPUnit\Framework\TestCase;

class CommissionServiceTest extends TestCase
{
    private CommissionServiceInterface $service;
    private $mockBinListAdapter;
    private $mockExchangeRateService;

    protected function setUp(): void
    {
        $this->mockBinListAdapter = $this->createMock(BinListAdapterInterface::class);
        $this->mockExchangeRateService = $this->createMock(ExchangeRateServiceInterface::class);

        $this->service = new CommissionService($this->mockBinListAdapter, $this->mockExchangeRateService);
    }

    public function testCalculateForEUCountryInEUR()
    {
        $account = new Account('123456', 100.0, 'EUR');
        $binDetails = $this->createMock(BinDetails::class);
        $exchangeRates = $this->createMock(ExchangeRates::class);

        // Mock BinListAdapter to return EU country details
        $this->mockBinListAdapter
            ->method('getBinDetails')
            ->with($account->getBin())
            ->willReturn($binDetails);

        // Mock binDetails to indicate EU country
        $binDetails
            ->method('isEU')
            ->willReturn(true);

        // Mock ExchangeRateService to return 1 for EUR
        $this->mockExchangeRateService
            ->method('getExchangeRates')
            ->willReturn($exchangeRates);

        $exchangeRates
            ->method('getRate')
            ->with('EUR')
            ->willReturn(1.0);

        $result = $this->service->calculate($account);

        $this->assertSame(1.0, $result);
    }

    public function testCalculateForNonEUCountryInEUR()
    {
        $account = new Account('654321', 200.0, 'EUR');
        $binDetails = $this->createMock(BinDetails::class);
        $exchangeRates = $this->createMock(ExchangeRates::class);

        // Mock BinListAdapter to return non-EU country details
        $this->mockBinListAdapter
            ->method('getBinDetails')
            ->with($account->getBin())
            ->willReturn($binDetails);

        // Mock binDetails to indicate non-EU country
        $binDetails
            ->method('isEU')
            ->willReturn(false);

        // Mock ExchangeRateService to return 1 for EUR
        $this->mockExchangeRateService
            ->method('getExchangeRates')
            ->willReturn($exchangeRates);

        $exchangeRates
            ->method('getRate')
            ->with('EUR')
            ->willReturn(1.0);

        $result = $this->service->calculate($account);

        $this->assertSame(4.0, $result);
    }

    public function testCalculateForNonEUCountryInNonEURCurrency()
    {
        $account = new Account('654321', 200.0, 'USD');
        $binDetails = $this->createMock(BinDetails::class);
        $exchangeRates = $this->createMock(ExchangeRates::class);

        // Mock BinListAdapter to return non-EU country details
        $this->mockBinListAdapter
            ->method('getBinDetails')
            ->with($account->getBin())
            ->willReturn($binDetails);

        // Mock binDetails to indicate non-EU country
        $binDetails
            ->method('isEU')
            ->willReturn(false);

        // Mock ExchangeRateService to return exchange rate for USD
        $this->mockExchangeRateService
            ->method('getExchangeRates')
            ->willReturn($exchangeRates);

        $exchangeRates
            ->method('getRate')
            ->with('USD')
            ->willReturn(1.2);

        $result = $this->service->calculate($account);

        $this->assertSame(3.34, round($result, 2));
    }

    public function testCalculateThrowsExceptionForMissingExchangeRate()
    {
        $account = new Account('123456', 100.0, 'GBP');
        $binDetails = $this->createMock(BinDetails::class);
        $exchangeRates = $this->createMock(ExchangeRates::class);

        $this->expectException(IncompatibleReturnValueException::class);

        // Mock BinListAdapter to return EU country details
        $this->mockBinListAdapter
            ->method('getBinDetails')
            ->with($account->getBin())
            ->willReturn($binDetails);

        // Mock binDetails to indicate EU country
        $binDetails
            ->method('isEU')
            ->willReturn(true);

        // Mock ExchangeRateService to return no rate for GBP
        $this->mockExchangeRateService
            ->method('getExchangeRates')
            ->willReturn($exchangeRates);

        $exchangeRates
            ->method('getRate')
            ->with('GBP')
            ->willReturn(null);

        $this->service->calculate($account);
    }
}
