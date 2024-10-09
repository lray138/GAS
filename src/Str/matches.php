<?php namespace lray138\GAS\Str;

const matches = __NAMESPACE__ . '\matches';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matches() {
    $matches = function($haystack, $needle) {

        if (isExpression($haystack)) {
            return matchesExpression($haystack, $needle);
        }

        return matchesString($haystack, $needle);
    };

    return call_user_func_array(FP\curry2($matches), func_get_args());
}