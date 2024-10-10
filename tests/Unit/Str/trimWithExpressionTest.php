<?php 

use function lray138\GAS\Str\trimWithExpression;
use function PHPUnit\Framework\assertEquals;

it('trims the haystack using a regular expression', function () {
    $needle = '/\s+/'; // A pattern to remove leading/trailing whitespace
    $haystack = "  Hello  World  ";
    $expected = "Hello  World"; // Only trims the spaces at the beginning and end

    $result = trimWithExpression($needle, $haystack);

    assertEquals($expected, $result);
});

it('trims the haystack using a custom pattern', function () {
    $needle = '/o+/'; // A pattern to trim consecutive "o"s
    $haystack = "ooHello Worldoo";
    $expected = "Hello World"; // Trims "oo" from the start and end

    $result = trimWithExpression($needle, $haystack);

    assertEquals($expected, $result);
});