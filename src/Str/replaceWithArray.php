<?php namespace lray138\GAS\Str;

use lray138\GAS\Functionl\curry3;

const replaceWithArray = __NAMESPACE__ . '\replaceWithArray';

/**
 * @param string $haystack
 * @param array  $needle
 * @param array  $replacement
 * @return string
 */
function replaceWithArray(array $needle, array $replacement, $haystack)
{
    foreach ($needle as $i => $next) {
        $replace_with = count($replacement) === 1 ? $replacement[0] : $replacement[$i];
        $haystack = replace($next, $replace_with, $haystack);
    }
    return $haystack;
}