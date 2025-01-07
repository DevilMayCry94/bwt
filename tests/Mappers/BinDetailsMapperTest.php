<?php

namespace BWT\Tests\Mappers;

use BWT\Mappers\BinDetailsMapper;
use BWT\Mappers\BinDetailsMapperInterface;
use BWT\Values\BinDetails;
use PHPUnit\Framework\TestCase;

class BinDetailsMapperTest extends TestCase
{
    private BinDetailsMapperInterface $mapper;

    protected function setUp(): void
    {
        $this->mapper = new BinDetailsMapper();
    }

    public function testMapBinDetailsSuccess()
    {
        // Test with valid data
        $inputData = [
            'country' => [
                'alpha2' => 'US',
            ],
        ];

        $binDetails = $this->mapper->mapBinDetails($inputData);

        // Assertions
        $this->assertInstanceOf(BinDetails::class, $binDetails);
        $this->assertSame('US', $binDetails->getCountryIso());
        $this->assertFalse($binDetails->isEU());
    }

    public function testMapBinDetailsInvalidAlpha2Type()
    {
        // Invalid type for 'alpha2' (not a string)
        $inputData = [
            'country' => [
                'alpha2' => null,
            ],
        ];

        $this->expectException(\TypeError::class);
        $this->mapper->mapBinDetails($inputData);
    }
}
