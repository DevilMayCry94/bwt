<?php

require __DIR__.'/autoload.php';

function appconfig(string $key = '') {
    $config = require 'config.php.example';

    if ($key) {
        $value = $config;
        foreach (explode('.', $key) as $item) {
            $value = $value[$item] ?? '';
        }

        return $value;
    }
    return $config;
}

(new \BWT\Console\IndexCommand())->run($argv);

