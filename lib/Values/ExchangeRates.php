<?php

namespace BWT\Values;

class ExchangeRates
{
    private array $rates = [];

    public function addRate(string $currency, float $value): self
    {
        $this->rates[$currency] = $value;

        return $this;
    }

    public function getRate(string $currency): float
    {
        return $this->rates[$currency] ?? 0;
    }

    public function __serialize(): array
    {
        return $this->rates;
    }

    public function __unserialize(array $data): void
    {
        $this->rates = $data;
    }
}
