<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const walk = __NAMESPACE__ . '\walk';

/**
 * @note I wonder why I used each first?  each was ... this is for arrays so we're not abstracting
 */
function walk()
{
    $f = function(callable $func, array $array) {
        array_walk($array, $func);
        return $array;
    };
    
    return curry($f)(...func_get_args());
}