<?php

use Brzuchal\JsonHighlighter\JsonHighlighter;
use PHPUnit\Framework\TestCase;

class JsonHighlighterTest extends TestCase
{
    public function testHighlightingValidJson(): void
    {
        $json = '{"name": "John", "age": 30, "married": false, "children": null}';
        $highlighted = JsonHighlighter::highlight($json);

        $this->assertStringContainsString("\e[1;36m", $highlighted); // For keys
        $this->assertStringContainsString("\e[0;32m", $highlighted); // For strings
        $this->assertStringContainsString("\e[0;38m", $highlighted); // For numbers
        $this->assertStringContainsString("\e[0;33m", $highlighted); // For booleans
        $this->assertStringContainsString("\e[0;37m", $highlighted); // For null and structural elements
    }

    public function testInvalidJson(): void
    {
        $json = '{"name": "John", "age": "30"'; // Invalid JSON
        $highlighted = JsonHighlighter::highlight($json);

        $this->assertEquals('Invalid JSON', $highlighted);
    }
}
