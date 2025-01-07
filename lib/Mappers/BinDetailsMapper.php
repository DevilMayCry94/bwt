<?php

namespace BWT\Mappers;

use BWT\Values\BinDetails;

class BinDetailsMapper implements BinDetailsMapperInterface
{
    public function mapBinDetails(array $data): BinDetails
    {
        return new BinDetails($data['country']['alpha2']);
    }
}
