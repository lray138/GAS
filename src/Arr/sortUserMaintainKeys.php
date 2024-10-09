<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const sortUserMaintainKeys = __NAMESPACE__ . '\sortUserMaintainKeys';

function sortUserMaintainKeys(callable $callback, array $array = []) {
    $f = function(callable $callback, array $array) {
        uasort($array, $callback);
        return $array;
    };

    return curry($f)(...func_get_args());
}