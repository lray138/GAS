<?php 

use function lray138\GAS\Arr\get;

it('returns the value associated with the key', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $result = get($key, $array);

    expect($result)->toBe('apple');
});

it('returns null if the key does not exist', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'c';

    $result = get($key, $array);

    expect($result)->toBeNull();
});

it('returns null if the array is empty', function () {
    $array = [];
    $key = 'a';

    $result = get($key, $array);

    expect($result)->toBeNull();
});

it('returns null if the input is not an array', function () {
    $array = 'not an array';
    $key = 'a';

    $result = get($key, $array);

    expect($result)->toBeNull();
});

it('returns null if the array is null', function () {
    $array = null;
    $key = 'a';

    $result = get($key, $array);

    expect($result)->toBeNull();
});

it('works with curried function - first part', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $curried = get($key);
    $result = $curried($array);

    expect($result)->toBe('apple');
});

it('works with curried function - both arguments', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $curried = get();
    $result = $curried($key, $array);

    expect($result)->toBe('apple');
});