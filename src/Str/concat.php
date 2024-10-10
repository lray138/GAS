<?php namespace lray138\GAS\Str;

const concat = __NAMESPACE__ . '/concat';

use function lray138\GAS\Str\concatN;

/* looks like this is a little voodoo magic here */
/* oct 9 2024 */
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