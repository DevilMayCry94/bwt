<?php

namespace BWT\Adapters;

use BWT\Exceptions\ExchangeRateApiException;
use BWT\Mappers\ExchangeRateApiMapper;
use BWT\Mappers\ExchangeRateApiMapperInterface;
use BWT\Services\Clients\ExchangeRateApiClient;
use BWT\Values\ExchangeRates;

class ExchangeRateAdapter implements ExchangeRateAdapterInterface
{
    public function __construct(
        private ExchangeRateApiClient $exchangeRateApiClient,
        private ExchangeRateApiMapperInterface $mapper
    ) {}

    public function getLatest(): ExchangeRates
    {
        try {
            $rates = $this->exchangeRateApiClient->get('/latest');

            return $this->mapper->mapRates($rates);
        } catch (\Throwable $throwable) {
            throw new ExchangeRateApiException($throwable->getMessage());
        }
    }
}
