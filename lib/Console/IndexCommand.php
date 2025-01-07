<?php

namespace BWT\Console;

use BWT\Adapters\BinListAdapter;
use BWT\Adapters\ExchangeRateAdapter;
use BWT\Cache\BWTMemcached;
use BWT\Mappers\BinDetailsMapper;
use BWT\Mappers\ExchangeRateApiMapper;
use BWT\Mappers\Mapper;
use BWT\Parsers\TextFileParserFactory;
use BWT\Services\Clients\BinListClient;
use BWT\Services\Clients\ExchangeRateApiClient;
use BWT\Services\CommissionService;
use BWT\Services\ExchangeRateService;

class IndexCommand
{
    public function run(array $args): void
    {
        $filePath = $args[1] ?? '';
        if (! file_exists($filePath)) {
            throw new \Exception(sprintf('File not found. File path: %s', $filePath));
        }

        $binListClientAdapter = new BinListAdapter(
            new BinListClient(),
            new BinDetailsMapper(),
        );
        $exchangeRateService = new ExchangeRateService(
            new ExchangeRateAdapter(new ExchangeRateApiClient(), new ExchangeRateApiMapper()),
            BWTMemcached::getInstance(),
        );
        $commissionService = new CommissionService($binListClientAdapter, $exchangeRateService);
        $textFileParserFactory = new TextFileParserFactory();
        foreach ($textFileParserFactory->lazyParse($filePath, new Mapper()) as $account) {
            echo $commissionService->calculate($account) . "\n";
            sleep(1);
        }
    }
}
