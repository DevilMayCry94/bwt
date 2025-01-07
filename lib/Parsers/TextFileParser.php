<?php

namespace BWT\Parsers;

class TextFileParser implements FileParserInterface
{
    public function getLazyData(string $filePath): \Generator
    {
        $input = fopen($filePath, "r");

        // Display a line of the file until the end
        while(! feof($input)) {
            $line = fgets($input);
            if ($line) {
                $rawData = trim($line);
                yield json_decode($rawData, true);
            }
        }
    }
}
