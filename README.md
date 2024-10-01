# JSON Highlighter

A simple PHP library for syntax highlighting JSON in the terminal.

## Installation

Install the package via Composer:

```bash
composer require brzuchal/json-highlighter
```

## Usage

You can use this library to highlight JSON strings in your terminal:

```php
use Brzuchal\JsonHighlighter\JsonHighlighter;

$json = '{
"name": "John",
"age": 30,
"married": false,
"children": null
}';

echo JsonHighlighter::highlight($json);
```

This will output syntax-highlighted JSON in your terminal using ANSI escape codes.

## Example Output

The output will look like:

```bash
{
    "name": "John",
    "age": 30,
    "married": false,
    "children": null
}
```

The keys will be in **light blue**, strings in **green**, numbers in **white**, booleans in **orange**, and `null` values in **light gray**.

## License

Michał Marcin Brzuchalski <michal.brzuchalski@gmail.com>

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
