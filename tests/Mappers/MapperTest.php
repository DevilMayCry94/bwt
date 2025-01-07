<?php

namespace BWT\Tests\Mappers;

use BWT\Mappers\Mapper;
use BWT\Mappers\MapperInterface;
use BWT\Values\Account;
use PHPUnit\Framework\TestCase;

class MapperTest extends TestCase
{
    private MapperInterface $mapper;

    protected function setUp(): void
    {
        $this->mapper = new Mapper();
    }

    public function testMapFileDataToAccountSuccess()
    {
        // Test with valid data
        $inputData = [
            'bin' => '123456',
            'amount' => '100.50',
            'currency' => 'USD',
        ];

        $account = $this->mapper->mapFileDataToAccount($inputData);

        // Assertions
        $this->assertInstanceOf(Account::class, $account);
        $this->assertSame('123456', $account->getBin());
        $this->assertSame(100.50, $account->getAmount());
        $this->assertSame('USD', $account->getCurrency());
    }

    public function testMapFileDataToAccountMissingField()
    {
        // Missing the 'bin' field
        $inputData = [
            'amount' => '100.50',
            'currency' => 'USD',
        ];

        $this->expectException(\Error::class);
        $this->mapper->mapFileDataToAccount($inputData);
    }

    public function testMapFileDataToAccountInvalidAmount()
    {
        // Invalid amount (non-numeric string)
        $inputData = [
            'bin' => '123456',
            'amount' => 'invalid_amount',
            'currency' => 'USD',
        ];

        $this->expectException(\TypeError::class);
        $this->mapper->mapFileDataToAccount($inputData);
    }

    public function testMapFileDataToAccountInvalidCurrency()
    {
        // Invalid currency (null instead of string)
        $inputData = [
            'bin' => '123456',
            'amount' => '100.50',
            'currency' => null,
        ];

        $this->expectException(\TypeError::class);
        $this->mapper->mapFileDataToAccount($inputData);
    }
}
