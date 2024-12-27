<?php namespace lray138\GAS\Str;

const matchesExpression = __NAMESPACE__ . '\matchesExpression';

// this was failing becasue the arguments are not in correct
// "functional" order 

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matchesExpression($needle, $haystack) {
    return preg_match($needle, $haystack) === 1;
}