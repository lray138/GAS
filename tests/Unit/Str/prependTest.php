<?php

use function lray138\GAS\Str\prepend;

test('prepends the string correctly', function () {
    expect(prepend("ab", "c"))->toBe("abc");
});