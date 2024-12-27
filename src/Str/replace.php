<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry3;
use function lray138\GAS\Types\isArray;

const replace = __NAMESPACE__ . '\replace';

/**
 * @param string       $haystack
 * @param string|array $needle
 * @param string|array $replacement
 * @return string
 */
function replace()
{
    //$haystack, $needle, $replacement
    $replace = function($needle, $replacement, $haystack) {
        if (isArray($needle)) {
            if(!isArray($replacement)) {
                return replaceWithArray($needle, [$replacement], $haystack);
            }
            return replaceWithArray($needle, $replacement, $haystack);
        }

        if (isExpression($needle)) {
            return replaceWithExpression($needle, $replacement, $haystack);
        }

        return replaceWithString($needle, $replacement, $haystack);
    };

    return call_user_func_array(curry3($replace), func_get_args());
}