<?php

namespace BWT\Tests\Parsers;

use BWT\Mappers\MapperInterface;
use BWT\Parsers\FileParserFactory;
use BWT\Parsers\FileParserInterface;
use BWT\Parsers\TextFileParser;
use BWT\Parsers\TextFileParserFactory;
use BWT\Values\Account;
use PHPUnit\Framework\TestCase;

class TextFileParserFactoryTest extends TestCase
{
    private $mockFileParser;
    private $mockMapper;
    private FileParserFactory $factory;

    protected function setUp(): void
    {
        // Mock FileParserInterface
        $this->mockFileParser = $this->createMock(FileParserInterface::class);

        // Mock MapperInterface
        $this->mockMapper = $this->createMock(MapperInterface::class);

        // Instantiate the TextFileParserFactory
        $this->factory = new TextFileParserFactory();
    }

    public function testRightFactory()
    {
        $parser = $this->factory->getParser();
        $this->assertInstanceOf(TextFileParser::class, $parser);
    }
}
