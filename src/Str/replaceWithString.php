<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const replaceWithString = __NAMESPACE__ . '/replaceWithString';

/**
 * @param string       $haystack
 * @param string|array $needle
 * @param string|array $replacement
 *
 * @return string
 */
function replaceWithString() {
    $f = function($needle, $replacement, $haystack) {
        return str_replace($needle, $replacement, $haystack);
    };

    return curryN(3)($f)(...func_get_args());
}