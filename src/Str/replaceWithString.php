<?php namespace lray138\GAS\Str;

use lray138\GAS\Functionl\curry3;

const replaceWithString = __NAMESPACE__ . '/replaceWithString';

/**
 * @param string       $haystack
 * @param string|array $needle
 * @param string|array $replacement
 *
 * @return string
 */
function replaceWithString() {
    $replaceWithString = function($needle, $replacement, $haystack) {
        return str_replace($needle, $replacement, $haystack);
    };

    return call_user_func_array(curry3($replaceWithString), func_get_args());
}