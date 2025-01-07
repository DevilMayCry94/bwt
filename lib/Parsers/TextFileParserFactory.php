<?php

namespace BWT\Parsers;

class TextFileParserFactory extends FileParserFactory
{
    public function getParser(): FileParserInterface
    {
        return new TextFileParser();
    }
}
