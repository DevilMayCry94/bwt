<?php

namespace BWT\Adapters;

use BWT\Exceptions\BinListApiException;
use BWT\Mappers\BinDetailsMapper;
use BWT\Mappers\BinDetailsMapperInterface;
use BWT\Services\Clients\BinListClient;
use BWT\Values\BinDetails;

class BinListAdapter implements BinListAdapterInterface
{
    public function __construct(
        private BinListClient $binListClient,
        private BinDetailsMapperInterface $binDetailsMapper
    ) {}

    public function getBinDetails(string $bin): BinDetails
    {
        $data = $this->binListClient->get('/'.$bin);
        if (! $data) {
            throw new BinListApiException('Bin list api error!');
        }

        return $this->binDetailsMapper->mapBinDetails($data);
    }
}
