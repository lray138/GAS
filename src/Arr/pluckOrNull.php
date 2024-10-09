<?php namespace lray138\GAS\Arr;

const pluckOrNull = __NAMESPACE__ . '\pluckOrNull';

/**
 * dunno, pluck returns null anyway, so not sure if I backdoored into this
 * or pluck returned false at some point.
 */

function pluckOrNull($pluck, array $from = []) {
    return pluck(...func_get_args());
}

// leaving for reference for now
// function pluckOrNull() {
//     $pluckOrNull = function($keys, array $array) {
//         if(is_array($keys)) {
//             $out = [];
//             walk(function($x) use ($array, &$out) {
//                 $out[] = has($x, $array) ? $array[$x] : null;
//             })($keys);
//             return $out;
//         } 

//         return has($keys, $array) ? $array[$keys] : null;
//     };
 
//     return call_user_func_array(FP\curry2($pluckOrNull), func_get_args());
// }