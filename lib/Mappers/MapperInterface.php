<?php

namespace BWT\Mappers;

use BWT\Values\Account;

interface MapperInterface
{
    public function mapFileDataToAccount(array $data): Account;
}
