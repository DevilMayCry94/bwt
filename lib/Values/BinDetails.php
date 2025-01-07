<?php

namespace BWT\Values;

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
            [
                'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI',
                'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT',
                'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',
            ]
        );
    }
}
