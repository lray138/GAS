<?php

use function lray138\GAS\Str\containsAny;

// Assuming you have autoloaded the function or included it properly
// require_once 'path/to/your/function.php';

it('returns true if any needle is found in the haystack', function () {
    // Testing with a single string needle and a string haystack
    $result = containsAny('hello', 'hello everyone');
    expect($result)->toBe(true);

    $result = containsAny('goodbye', 'hello everyone');
    expect($result)->toBe(false);

    // Testing with an array needle and a string haystack
    $result = containsAny(['hello', 'world'], 'hello everyone');
    expect($result)->toBe(true);

    $result = containsAny(['goodbye', 'everyone'], 'hello everyone');
    expect($result)->toBe(true);
});

it('returns false if none of the needles are found in the haystack', function () {
    // Testing with a single string needle and a string haystack
    $result = containsAny('goodbye', 'hello everyone');
    expect($result)->toBe(false);

    // Testing with an array needle and a string haystack
    $result = containsAny(['no', 'match'], 'hello everyone');
    expect($result)->toBe(false);
});