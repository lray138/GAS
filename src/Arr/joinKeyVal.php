<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const joinKeyVal = __NAMESPACE__ . '\joinKeyVal';

/**
 * This function is a little weird in that it is returning an array 
 * which makes sense for the original use case, but otherwise isnt really 
 * "join" necessarily
 */
function joinKeyVal(): array {
    $f = function($delimiter, $array) {
        $out = [];
        walk(function($value, $key) use (&$out, &$delimiter) {
            $out[] = $key . $delimiter . $value;
        }, $array);
        return $out;
    };

    return curry($f)(...func_get_args());
}