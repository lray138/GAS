<?php 

use const lray138\GAS\Arr\filter;
use function lray138\GAS\Arr\filterUseBoth;
use function lray138\GAS\Functional\{__, flipCurry3};

function filterKeysAndValues($value, $key) {
    return strpos($key, 't') === 0 && $value > 2;
}

it('1) it filters by both keys and values', function() {
    $array = [
        'first' => 1,
        'second' => 2,
        'third' => 3,
        'fourth' => 4
    ];

    $result = filterUseBoth("filterKeysAndValues", $array);
    expect($result)->toBe(["third" => 3]);
});

it('2) it filters by both keys and values', function() {
    $array = [
        'first' => 1,
        'second' => 2,
        'third' => 3,
        'fourth' => 4
    ];

    $result = filterUseBoth("filterKeysAndValues")($array);
    expect($result)->toBe(["third" => 3]);
});