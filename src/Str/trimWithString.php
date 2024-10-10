<?php namespace lray138\GAS\Str;

const trimWithString = __NAMESPACE__ . '/trimWithString';

use function lray138\GAS\Functional\curryN;

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 * 
 *  this code was from Chris Pitt typed PHP book, but was not in 
 *  what I consider "functional order"
 *  ok, here's the prob then I switched it up there and not everywhere... 
 */
function trimWithString($characters, $string = null) {
    $f = function($characters, $string) {
        return is_null($characters) ? \trim($string) : \trim($string, $characters);
    };

    return curryN(2)($f)(...func_get_args());
}