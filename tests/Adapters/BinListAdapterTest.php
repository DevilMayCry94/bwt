<?php

namespace BWT\Tests\Adapters;

use BWT\Adapters\BinListAdapter;
use BWT\Adapters\BinListAdapterInterface;
use BWT\Exceptions\BinListApiException;
use BWT\Mappers\BinDetailsMapperInterface;
use BWT\Services\Clients\BinListClient;
use BWT\Values\BinDetails;
use PHPUnit\Framework\TestCase;

class BinListAdapterTest extends TestCase
{
    private BinListAdapterInterface $adapter;
    private $mockBinListClient;
    private $mockBinDetailsMapper;

    protected function setUp(): void
    {
        $this->mockBinListClient = $this->createMock(BinListClient::class);
        $this->mockBinDetailsMapper = $this->createMock(BinDetailsMapperInterface::class);

        // Use dependency injection to replace dependencies
        $this->adapter = new BinListAdapter($this->mockBinListClient, $this->mockBinDetailsMapper);
    }

    public function testGetBinDetailsSuccess()
    {
        $bin = '123456';
        $apiResponse = ['country' => ['alpha2' => 'US']];
        $expectedBinDetails = new BinDetails('US');

        // Mock BinListClient behavior
        $this->mockBinListClient
            ->method('get')
            ->with('/'.$bin)
            ->willReturn($apiResponse);

        // Mock BinDetailsMapper behavior
        $this->mockBinDetailsMapper
            ->method('mapBinDetails')
            ->with($apiResponse)
            ->willReturn($expectedBinDetails);

        $result = $this->adapter->getBinDetails($bin);

        // Assertions
        $this->assertInstanceOf(BinDetails::class, $result);
        $this->assertSame('US', $result->getCountryIso());
    }

    public function testGetBinDetailsApiError()
    {
        $bin = '123456';

        // Mock BinListClient behavior to simulate an API error (return null/false)
        $this->mockBinListClient
            ->method('get')
            ->with('/'.$bin)
            ->willReturn([]);

        $this->expectException(BinListApiException::class);
        $this->expectExceptionMessage('Bin list api error!');

        $this->adapter->getBinDetails($bin);
    }

    public function testGetBinDetailsMapperThrowsError()
    {
        $bin = '123456';
        $apiResponse = ['country' => ['alpha2' => 'US']];

        // Mock BinListClient behavior
        $this->mockBinListClient
            ->method('get')
            ->with('/'.$bin)
            ->willReturn($apiResponse);

        // Mock BinDetailsMapper behavior to throw an exception
        $this->mockBinDetailsMapper
            ->method('mapBinDetails')
            ->willThrowException(new \Exception('Mapping error'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Mapping error');

        $this->adapter->getBinDetails($bin);
    }
}
