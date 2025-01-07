<?php

namespace BWT\Services;

use BWT\Values\Account;

interface CommissionServiceInterface
{
    public function calculate(Account $account): float;
}
