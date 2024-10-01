<?php

declare(strict_types=1);

namespace Brzuchal\JsonHighlighter;

use JsonException;

final class JsonHighlighter
{
    private const COLOR_KEY      = "\e[1;36m"; // Cyan/light blue for keys
    private const COLOR_STRING   = "\e[0;32m"; // Green for strings
    private const COLOR_NUMBER   = "\e[0;38m"; // White for numbers
    private const COLOR_BOOL     = "\e[0;33m"; // Orange for boolean values (true, false)
    private const COLOR_NULL     = "\e[0;37m"; // Light gray/white for null
    private const COLOR_BRACKETS = "\e[0;37m"; // Light gray for brackets/braces/commas/colons
    private const COLOR_COLON    = "\e[0;37m"; // Light gray for colons
    private const COLOR_COMMA    = "\e[0;37m"; // Light gray for commas
    private const COLOR_RESET    = "\e[0m";    // Reset color
    // phpcs:ignore
    const JSON_HIGHLIGHT_REGEX = '/(?<key>"[^"]*")\s*:\s*|(?<string>"[^"\\\\]*(?:\\\\.[^"\\\\]*)*")|(?<number>-?\d+(?:\.\d+)?)|\b(?<bool>true|false)\b|\b(?<null>null)\b|(?<brackets>[{}[\]])|(?<colon>:)|(?<comma>,)/';

    /**
     * @throws JsonException
     */
    public static function highlight(string $json): string
    {
        $decodedJson = \json_decode($json, true, flags: \JSON_THROW_ON_ERROR);
        $json = \json_encode($decodedJson, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE);

        return \preg_replace_callback(
                self::JSON_HIGHLIGHT_REGEX,
                self::replaceCallback(...),
                $json
            ) . \PHP_EOL;
    }

    private static function replaceCallback(array $matches): string
    {
        if ($matches['key'] !== '') {
            return self::colorize($matches['key'], self::COLOR_KEY) . self::colorize(': ', self::COLOR_COLON);
        }

        if ($matches['string'] !== '') {
            return self::colorize($matches['string'], self::COLOR_STRING);
        }

        if ($matches['number'] !== '') {
            return self::colorize($matches['number'], self::COLOR_NUMBER);
        }

        if ($matches['bool'] !== '') {
            return self::colorize($matches['bool'], self::COLOR_BOOL);
        }

        if ($matches['null'] !== '') {
            return self::colorize($matches['null'], self::COLOR_NULL);
        }

        if ($matches['brackets'] !== '') {
            return self::colorize($matches['brackets'], self::COLOR_BRACKETS);
        }

        if ($matches['colon'] !== '') {
            return self::colorize($matches['colon'], self::COLOR_COLON);
        }

        if ($matches['comma'] !== '') {
            return self::colorize($matches['comma'], self::COLOR_COMMA);
        }

        return $matches[0];
    }

    private static function colorize(string $text, string $color): string
    {
        return $color . $text . self::COLOR_RESET;
    }
}
