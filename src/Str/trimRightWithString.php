<?php namespace lray138\GAS\Str;

const trimRightWithString = __NAMESPACE__ . '/trimRightWithString';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimRightWithString($haystack, $needle) {
    return \rtrim($haystack, $needle);
}