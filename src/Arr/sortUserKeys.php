<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const sortUserKeys = __NAMESPACE__ . '\sortUserKeys';

function sortUserKeys(callable $callback, array $array = []) {
    $f = function(callable $callback, array $array) {
        uksort($array, $callback);
        return $array;
    };

    return curry($f)(...func_get_args());
}