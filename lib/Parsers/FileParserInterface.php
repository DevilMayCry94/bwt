<?php

namespace BWT\Parsers;

interface FileParserInterface
{
    public function getLazyData(string $filePath): \Generator;
}
