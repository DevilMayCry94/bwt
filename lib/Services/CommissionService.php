<?php

namespace BWT\Services;

use BWT\Adapters\BinListAdapterInterface;
use BWT\Enums\ECurrency;
use BWT\Values\Account;

class CommissionService implements CommissionServiceInterface
{
    public function __construct(
        private BinListAdapterInterface $binListClientAdapter,
        private ExchangeRateServiceInterface $exchangeRateService
    ) {}

    public function calculate(Account $account): float
    {
        $binDetails = $this->binListClientAdapter->getBinDetails($account->getBin());
        $exchangeRates = $this->exchangeRateService->getExchangeRates();
        $rate = $exchangeRates->getRate($account->getCurrency());
        $amount = $account->getAmount();

        if ($account->getCurrency() !== ECurrency::Eur->value || $rate > 0) {
            $amount /= $rate;
        }

        $result = $amount * ($binDetails->isEU() ? 0.01 : 0.02);
        return ceil($result * 100) / 100;
    }
}
