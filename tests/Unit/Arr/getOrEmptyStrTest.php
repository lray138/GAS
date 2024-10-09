<?php 

use function lray138\GAS\Arr\getOrEmptyStr;

it('returns the value associated with the key', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $result = getOrEmptyStr($key, $array);

    expect($result)->toBe('apple');
});

it('returns an empty string if the value is null', function () {
    $array = ['a' => null, 'b' => 'banana'];
    $key = 'a';

    $result = getOrEmptyStr($key, $array);

    expect($result)->toBe('');
});

it('returns an empty string if the key does not exist', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'c';

    $result = getOrEmptyStr($key, $array);

    expect($result)->toBe('');
});

it('works with curried function - first part', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $curried = getOrEmptyStr($key);
    $result = $curried($array);

    expect($result)->toBe('apple');
});

it('works with curried function - second part', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];
    $key = 'a';

    $curried = getOrEmptyStr();
    $result = $curried($key);
    $result = $result($array);

    expect($result)->toBe('apple');
});