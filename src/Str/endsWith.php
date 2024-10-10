<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry2;

const endsWith = __NAMESPACE__ . '\endsWith';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function endsWith()
{
    $endsWith = function($needle, $haystack) {
        if (isExpression($needle)) {
            return endsWithExpression($haystack, $needle);
        }

        return endsWithString($haystack, $needle);
    };

    return call_user_func_array(curry2($endsWith), func_get_args());
}