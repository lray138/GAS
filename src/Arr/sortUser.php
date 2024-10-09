<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const sortUser = __NAMESPACE__ . '\sortUser';

function sortUser(callable $callback, array $array = []) {
    $f = function(callable $callback, array $array) {
        usort($array, $callback);
        return $array;
    };

    return curry($f)(...func_get_args());
}