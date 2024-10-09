<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry3 as curry;

const pushKeyVal = __NAMESPACE__ . '\pushKeyVal';

function pushKeyVal() {
    $f = function($key, $value, $array) {
        // empty will return positive for 0, make sure it's a string
        if(is_string($key) && empty($key)) {
            return $array;
        }

        $array[$key] = $value;
        return $array;
    };

    return curry($f)(...func_get_args());
}