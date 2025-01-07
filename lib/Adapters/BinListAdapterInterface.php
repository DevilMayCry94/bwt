<?php

namespace BWT\Adapters;

use BWT\Values\BinDetails;

interface BinListAdapterInterface
{
    public function getBinDetails(string $bin): BinDetails;
}
