<?php

namespace BWT\Mappers;

use BWT\Values\Account;

class Mapper implements MapperInterface
{
    public function mapFileDataToAccount(array $data): Account
    {
        return new Account(
            $data['bin'],
            $data['amount'],
            $data['currency'],
        );
    }
}
