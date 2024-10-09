<?php namespace lray138\GAS\Str;

const concat = __NAMESPACE__ . '/concat';

function concat() {

    return count(func_get_args()) > 1 
        ? concatN(count(func_get_args()), ...func_get_args())
        : concatN(2, ...func_get_args());

   
    // $concat = function($x, $y) {
    //     return is_array($x) 
    //         ? \implode($x) . $y 
    //         : $x . $y;
    // };
    
    // return call_user_func_array(curry2($concat), func_get_args());
}
