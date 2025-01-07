<?php

namespace BWT\Services\Clients;

use BWT\Services\Clients\Configs\ClientConfig;

class BinListClient extends ServiceClient
{
    public function getClientConfig(): ClientConfig
    {
        return new ClientConfig(appconfig('bin_list.base_url'));
    }
}
