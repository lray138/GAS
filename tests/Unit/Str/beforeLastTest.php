<?php

use function lray138\GAS\Str\beforeLast;

it('returns the correct value', function () {
    $result = beforeLast("/", "this/is/a/test");
    expect($result)->toBe("this/is/a");
});