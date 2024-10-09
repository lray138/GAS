<?php namespace lray138\GAS\Functional;

const arityN = __NAMESPACE__ . '\arityN';

/**
 * Function description.
 */
function arityN($n, $callable, ...$args) {
    if(count($args) >= $n) {
        $result = $callable(...array_slice($args, 0, $n));
        while($result instanceof \Closure) {
            $result = $result(null);
        }
        return $result;
    }

    return function() use ($n, $callable, $args) {
        return call_user_func_array(arityN, array_merge([$n, $callable], $args, func_get_args()));
    };
    // return function() use ($n, $callable) {
    //     $args = func_get_args();
    //     if(count($args) >= $n) {
    //         $result = $callable(...array_slice(func_get_args(), 0, $n));
    //         while($result instanceof \Closure) {
    //             $result = $result(null);
    //         }
    //         return $result;
    //     }

    //     return function() use ($n, $callable, $args) {
    //         return call_user_func_array(arityN($n, $callable), Arr\merge($args, func_get_args()));
    //     };
    // };
}