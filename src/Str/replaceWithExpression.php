<?php namespace lray138\GAS\Str;

use lray138\GAS\Functionl\curry3;

const replaceWithExpression = __NAMESPACE__ . '\replaceWithExpression';

/**
 * @param string       $haystack
 * @param string|array $needle
 * @param string|array $replacement
 *
 * @return string
 */
function replaceWithExpression() {
    $replaceWithExpression = function($needle, $replacement, $haystack) {
        return (string) preg_replace($needle, $replacement, $haystack);
    };

    return call_user_func_array(curry3($replaceWithExpression), func_get_args());
}