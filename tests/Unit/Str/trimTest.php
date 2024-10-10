<?php 

use function lray138\GAS\Str\trim;
use function PHPUnit\Framework\assertEquals;

it('trims using a string as the needle', function () {
    // Mock or assume that `isExpression` returns false for this test case
    $needle = " ";
    $haystack = "  Hello World  ";
    $expected = "Hello World";

    $result = trim($needle, $haystack);

    expect($result)->toBe("Hello World");
    //assertEquals($expected, $result);
});

it('trims using an expression as the needle', function () {
    // Mock or assume that `isExpression` returns true for this test case
    $needle = "/\s+/"; // Example of a regular expression
    $haystack = "  Hello  World  ";
    $expected = "Hello  World"; // Assuming the expression removes all whitespace

    $result = trim($needle, $haystack);

    assertEquals($expected, $result);
});