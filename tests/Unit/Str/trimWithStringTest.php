<?php 

use function lray138\GAS\Str\trimWithString;
use function PHPUnit\Framework\assertEquals;

it('trims the string with default characters', function () {
    $result = trimWithString(null, '  Hello World  ');
    assertEquals('Hello World', $result);
});

it('trims the string with custom characters', function () {
    $result = trimWithString('Hed', 'Hello World');
    assertEquals('llo Worl', $result);
});

it('trims an empty string', function () {
    $result = trimWithString(null, '    ');
    assertEquals('', $result);
});

it('trims the string with special characters', function () {
    $result = trimWithString('!@', '@Hello World!');
    assertEquals('Hello World', $result);
});

it('returns null when string is null', function () {
    $result = trimWithString(null, null);
    assertEquals(null, $result);
});

it('trims the string with no characters passed', function () {
    $result = trimWithString('', '  Hello World  ');
    assertEquals('  Hello World  ', $result); // No trimming should occur since no characters are passed.
});