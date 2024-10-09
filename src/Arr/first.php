<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const first = __NAMESPACE__ . '\first';

// not workign like I need anyway
/**
 * @todo verify this is needed, and not just an alias of "find"
 */
function first() {
    $first = function($callable, $array) {
        foreach($array as $key => $val) {
            if($callable($val, $key)) {
                return $val;
            }
        };
        
        return null;
    };

    return curry($first)(...func_get_args());
}