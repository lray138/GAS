<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const find = __NAMESPACE__ . '\find';

function find() {
    $f = function($callable, $array) {
        foreach($array as $key => $val) {
            if($callable($val, $key)) {
                return $array[$key];
            }
        }
    };

    return curry($f)(...func_get_args());
}