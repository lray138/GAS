<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2;

const getOrEmptyStr = __NAMESPACE__ . '\getOrEmptyStr';

/**
 *
 * 
 */
function getOrEmptyStr() {
    $f = function($key, $array) {
        return getOrElse($key, "", $array);
    };

    return curry2($f)(...func_get_args());
}