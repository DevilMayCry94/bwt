<?php

namespace BWT\Values;

use BWT\Enums\EEuCountries;

class BinDetails
{
    public function __construct(
        private string $countryIso
    ) {}

    public function getCountryIso(): string
    {
        return $this->countryIso;
    }

    public function isEU(): bool
    {
        return in_array(
            $this->countryIso,
            EEuCountries::values()
        );
    }
}
