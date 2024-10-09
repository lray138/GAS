<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const join = __NAMESPACE__ . '\join';

/**
 * @param array  $array
 * @param string $glue
 * 
 * NOTE: I can already see his order wasn't "right" and this is probably from 
 * Chris Pitt book
 * 
 * @return string
 * Note: this is like "filter" where I had tunnel vision and 
 * checking for the argument count being one and first argument being 
 * array removes the need for the "joinE" or "joinEmpty" function.
 * 
 * also noting join is an aliase of "implode" in the PHP language
 * also noting join/implode are grouped under "String" functions in PHP
 */
function join(string|array $arg1, array $arg2 = null) {
    $args = func_get_args();

    if(count($args) === 1 && is_array($args[0])) {
        return \join($args[0]);
    }

    $f = function(string $glue, array $array) {
        return \join($glue, $array);
    };

    return curry($f)(...func_get_args());
}