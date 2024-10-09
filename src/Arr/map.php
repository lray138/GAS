<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const map = __NAMESPACE__ . '\map';

/**
 * @param callable $callback
 * @param array    $array
 *
 * @return array
 * @note there was a reason for the foreach but
 * i forget why
 * well i'm back on Jul 13, 2023 and if I use foreach I can pass the key in
 * which can come in handy, although maybe I'm approachign the problem wrong
 * ok, well now I know
 * --
 * dong that was dump, but also, if we are focusing on Arr here we should 
 * simply be auto currying the "array_map" function and getting args straigthened out.
 */
function map($callable, array $array = null) {
    $f = function($callable, array $array) {
        return array_map($callable, $array);
    };

    return curry($f)(...func_get_args());
}

// leaving to notice difference where we originally cleaning up array functions
// vs trying to handle other iterables
function map_() {
    $f = function($f, $array) {
        foreach($array as $key => $val) {
            $array[$key] = $f($array[$key]);
        }
        return $array;
    };

    return curry($f)(...func_get_args());
}