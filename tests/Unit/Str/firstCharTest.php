<?php

use function lray138\GAS\Str\firstChar;

it('returns the first character of a string', function () {
    expect(firstChar('hello'))->toBe('h');
});

it('returns an empty string when the input is empty', function () {
    expect(firstChar(''))->toBe('');
});

it('returns the first character of a single character string', function () {
    expect(firstChar('a'))->toBe('a');
});

it('returns the first character of a string with special characters', function () {
    expect(firstChar('!hello'))->toBe('!');
});