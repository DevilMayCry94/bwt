<?php

namespace BWT\Mappers;

use BWT\Values\BinDetails;

interface BinDetailsMapperInterface
{
    public function mapBinDetails(array $data): BinDetails;
}
