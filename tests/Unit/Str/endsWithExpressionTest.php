<?php 

use function lray138\GAS\Str\endsWithExpression;

it('works with a regular excpression', function() {
	expect(endsWithExpression("/ful$/", "wonderful"))->toBeTrue();
});