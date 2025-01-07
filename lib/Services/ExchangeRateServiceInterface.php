<?php

namespace BWT\Services;

use BWT\Values\ExchangeRates;

interface ExchangeRateServiceInterface
{
    public function getExchangeRates(): ExchangeRates;
}
