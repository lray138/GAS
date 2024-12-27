<?php 

use function lray138\GAS\Str\endsWith;

it('works with a string', function () {
    expect(endsWith("ful", "hopeful"))->toBeTrue();
});

it('works with a regular excpression', function() {
	expect(endsWith("/ful$/", "wonderful"))->toBeTrue();
});