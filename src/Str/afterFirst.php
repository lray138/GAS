<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry2 as curry;

const afterFirst = __NAMESPACE__ . '\afterFirst';

/**
 * @todo remove the "old way" after documenting
 */
function afterFirst() {
    $f = function($delimeter, $string) {
        return afterNth(1, $delimeter, $string);
    };

    return curry($f)(...func_get_args());
}


function afterFirst_OldWay() {
    $afterFirst = function($needle, $haystack) {
        return Arr\join($needle, Arr\tail(explode($needle, $haystack)));
    };

    return call_user_func_array(curry2($afterFirst), func_get_args());
}