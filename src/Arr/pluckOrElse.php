<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry3 as curry;

const pluckOrElse = __NAMESPACE__ . '\pluckOrElse';

/** 
 * note: not sure where or if I had made this in terms of running the callback 
 * on the array
 */
function pluckOrElse($pluck, $or_else = null, $from = []) {
    $f = function($pluck, $or_else, $from) {
        $plucked = pluck($pluck, $from);

        if(!is_null($plucked)) return $plucked;

        return is_callable($or_else) 
            ? $or_else($from) 
            : $or_else;
    };

    return curry($f)(...func_get_args());
}