<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const pluck = __NAMESPACE__ . '\pluck';

function pluck() {
    $f = function($key, $array) {
        if(isset($array[$key])) {
            return $array[$key];
        }
    };
 
    return curry($f)(...func_get_args());
}