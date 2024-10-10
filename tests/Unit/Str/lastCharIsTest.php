<?php

use function lray138\GAS\Str\lastCharIs;

it('returns true if the last character matches the needle', function () {
    expect(lastCharIs("a", "aba"))->toBeTrue();
});

it('returns false if the last character does not match the needle', function () {
    expect(lastCharIs("z", "aba"))->toBeFalse();
});