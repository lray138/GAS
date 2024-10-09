<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry3 as curry;

const pluckOr = __NAMESPACE__ . '\pluckOr';

/** 
 * 
 */
function pluckOr() {
    $f = function($key, $else, $arr) {
        $plucked = pluck($key, $arr);

        if(!is_null($plucked)) return $plucked;

        return is_callable($else) 
            ? $else($arr) 
            : $else;
    };

    return curry($f)(...func_get_args());
}