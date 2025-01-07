<?php

namespace BWT\Tests\Parsers;

use BWT\Parsers\TextFileParser;
use PHPUnit\Framework\TestCase;

class TextFileParserTest extends TestCase
{
    public function testGetLazyData()
    {
        // Create a temporary file and add sample JSON data
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        $data = [
            json_encode(['id' => 1, 'name' => 'Alice']),
            json_encode(['id' => 2, 'name' => 'Bob']),
            json_encode(['id' => 3, 'name' => 'Charlie']),
        ];
        file_put_contents($tempFile, implode(PHP_EOL, $data));

        // Instantiate the class and call the method
        $processor = new TextFileParser();
        $generator = $processor->getLazyData($tempFile);

        // Collect the results
        $results = [];
        foreach ($generator as $item) {
            $results[] = $item;
        }

        $expected = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie'],
        ];
        $this->assertSame($expected, $results);

        unlink($tempFile);
    }
}
