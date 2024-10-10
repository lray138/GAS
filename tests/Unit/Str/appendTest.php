<?php

use function lray138\GAS\Str\append;

it('appends correctly', function () {
    $result = append("bc", "a");
    expect($result)->toBe("abc");
});