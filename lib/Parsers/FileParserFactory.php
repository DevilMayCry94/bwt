<?php

namespace BWT\Parsers;

use BWT\Mappers\MapperInterface;
use BWT\Values\Account;

abstract class FileParserFactory
{
    abstract public function getParser(): FileParserInterface;

    /**
     * @param string $filePath
     * @param MapperInterface $mapper
     * @return \Generator<Account>
     */
    public function lazyParse(string $filePath, MapperInterface $mapper)
    {
        $parser = $this->getParser();
        foreach ($parser->getLazyData($filePath) as $rawData) {
            yield $mapper->mapFileDataToAccount($rawData);
        }
    }
}
