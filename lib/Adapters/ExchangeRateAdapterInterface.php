<?php

namespace BWT\Adapters;

use BWT\Values\ExchangeRates;

interface ExchangeRateAdapterInterface
{
    public function getLatest(): ExchangeRates;
}
