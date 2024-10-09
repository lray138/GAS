<?php 

use function lray138\GAS\Arr\filterEmpty;

it('filters an array with a callback', function() {
    $array = [1, 2, 3, 4, 5, 6];
    $result = filterEmpty($array);

    expect(array_values($result))->toBe([1, 2, 3, 4, 5, 6]);
});

it('filters an array without a callback', function() {
    $array = [0, 1, false, 2, '', 3];
    $result = filterEmpty($array);
    expect(array_values($result))->toBe([1, 2, 3]);
});