<?php

namespace BWT\Services\Clients;

use BWT\Core\Config;
use BWT\Services\Clients\Configs\ClientConfig;

class BinListClient extends ServiceClient
{
    public function getClientConfig(): ClientConfig
    {
        return new ClientConfig(Config::get('bin_list.base_url'));
    }
}
