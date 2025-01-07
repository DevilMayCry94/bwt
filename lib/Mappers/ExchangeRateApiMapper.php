<?php
declare(strict_types=1);

namespace BWT\Mappers;

use BWT\Values\ExchangeRates;

class ExchangeRateApiMapper implements ExchangeRateApiMapperInterface
{
    public function mapRates(array $data): ExchangeRates
    {
        $exchangeRates = new ExchangeRates();
        foreach ($data['rates'] as $currency => $value) {
            $exchangeRates->addRate($currency, (float) $value);
        }

        return $exchangeRates;
    }
}
