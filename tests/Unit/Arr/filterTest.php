<?php 

use const lray138\GAS\Arr\filter;
use function lray138\GAS\Arr\filter;
use function lray138\GAS\Functional\{__, flipCurry3};

function filterKeys($key) {
    return strpos($key, 't') === 0;
}

function filterKeysAndValues($value, $key) {
    return strpos($key, 't') === 0 && $value > 2;
}

it('filters an array with a callback', function() {
    $array = [1, 2, 3, 4, 5, 6];
    $callback = fn($value) => $value % 2 === 0;
    $result = filter($callback, $array);

    expect(array_values($result))->toBe([2, 4, 6]);
});

it('filters an array without a callback', function() {
    $array = [0, 1, false, 2, '', 3];
    $result = filter($array);
    expect(array_values($result))->toBe([1, 2, 3]);
});

it('X) it filters by keys', function() {

    $array = ["test" => 26, "whatever" => 2, "OK" => 1];

    $result = flipCurry3(filter)(ARRAY_FILTER_USE_KEY, __(), "filterKeys")($array);

    //$result = array_filter($array, "filterKeys", ARRAY_FILTER_USE_KEY);

    // "OMG I actually love this hahahahahahah"
    // (for the moment)

    expect($result)->toBe(["test" => 26]);
});

it('X) it filters by both keys and values', function() {

    $array = [
        'first' => 1,
        'second' => 2,
        'third' => 3,
        'fourth' => 4
    ];

    $result = flipCurry3(filter)(ARRAY_FILTER_USE_BOTH, __(), "filterKeysAndValues")($array);

    expect($result)->toBe(["third" => 3]);
});