<?php namespace lray138\GAS\Str;

const startsWith = __NAMESPACE__ . '\startsWith';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function startsWith() {
    $startsWith = function($needle, $haystack) {
        if (isExpression($needle)) {
            return startsWithExpression($haystack, $needle);
        }

        return startsWithString($haystack, $needle);
    };
    
    return call_user_func_array(curry2($startsWith), func_get_args());
}