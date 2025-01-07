<?php

namespace BWT\Tests\Mappers;

use BWT\Mappers\ExchangeRateApiMapper;
use BWT\Mappers\ExchangeRateApiMapperInterface;
use BWT\Values\ExchangeRates;
use PHPUnit\Framework\TestCase;

class ExchangeRateApiMapperTest extends TestCase
{
    private ExchangeRateApiMapperInterface $mapper;

    protected function setUp(): void
    {
        $this->mapper = new ExchangeRateApiMapper();
    }

    public function testMapRatesSuccess()
    {
        // Test with valid data
        $inputData = [
            'rates' => [
                'USD' => '1.12',
                'EUR' => '0.85',
                'GBP' => '0.76',
            ],
        ];

        $exchangeRates = $this->mapper->mapRates($inputData);

        // Assertions
        $this->assertInstanceOf(ExchangeRates::class, $exchangeRates);
        $this->assertSame(1.12, $exchangeRates->getRate('USD'));
        $this->assertSame(0.85, $exchangeRates->getRate('EUR'));
        $this->assertSame(0.76, $exchangeRates->getRate('GBP'));
    }
}
