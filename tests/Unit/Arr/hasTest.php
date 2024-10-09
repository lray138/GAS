<?php 

use function lray138\GAS\Arr\has;

it('returns false if the key does not exist in the array', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'c';

    $result = has($key, $array);

    expect($result)->toBeFalse();
});

it('returns false if the array is empty', function () {
    $array = [];
    $key = 'a';

    $result = has($key, $array);

    expect($result)->toBeFalse();
});

it('works with curried function - first part', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $curried = has($key);
    $result = $curried($array);

    expect($result)->toBeTrue();
});

it('works with curried function - both arguments', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $curried = has();
    $result = $curried($key, $array);

    expect($result)->toBeTrue();
});