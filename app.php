<?php

require __DIR__.'/autoload.php';

const BASE_DIR = __DIR__;

(new \BWT\Console\IndexCommand())->run($argv);

