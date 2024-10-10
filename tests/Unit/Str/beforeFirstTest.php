<?php

use function lray138\GAS\Str\beforeFirst;

it('returns the right value', function () {
    $result = beforeFirst("/", "this/is/a/test");
    expect($result)->toBe("this");
});