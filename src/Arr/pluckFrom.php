<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\flip2 as flip;
use function lray138\GAS\Functional\curry2 as curry;

const pluckFrom = __NAMESPACE__ . '\pluckFrom';

// this is also me doing a "short cut" for flip(pluck), which I would say
// less "cruft" the better, I can also see I left an old version for some reason

function pluckFrom(array $array, $key = null) {
    return curry(flip(pluck))(...func_get_args());
}

// function pluckFrom() {
//     $pluckFrom = function(array $array, $key) {
//         return has($key, $array) ? $array[$key] : null;
//     };

//     return call_user_func_array(FP\curry2($pluckFrom), func_get_args());
// }