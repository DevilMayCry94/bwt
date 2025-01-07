<?php

namespace BWT\Mappers;

use BWT\Values\ExchangeRates;

interface ExchangeRateApiMapperInterface
{
    public function mapRates(array $data): ExchangeRates;
}
