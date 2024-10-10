<?php 

use function lray138\GAS\Str\contains;

it('works for a substring', function () {
    expect(contains("cde", "abcdef"))->toBeTrue();
});