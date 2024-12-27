<?php namespace lray138\GAS\Str;

// if this is Chris Pitt then not sure you need ends with expression cause
// ends with string makes sense.

const endsWithExpression = __NAMESPACE__ . '\endsWithExpression';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 * 
 */
function endsWithExpression($needle, $haystack) {
    $pattern = slice($needle, 1, length($needle) - 2);
    return preg_match("#{$pattern}$#", $haystack) === 1;
    // leaving below for example.
    // return matches("#{$pattern}$#", $haystack);
}