<?php 

use function lray138\GAS\Arr\joinE;

it('1) joins with empty string when only array is provided', function () {
    $array = ["a", "b", "c"];
    $expectedResult = 'abc';
    expect(joinE($array))->toBe($expectedResult);
});