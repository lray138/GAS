<?php namespace lray138\GAS\Str;

const split = __NAMESPACE__ . '/split';

/**
 * @param string      $haystack
 * @param string|null $needle
 * @param int         $limit
 *
 * @return array
 */
function split($haystack, $needle = null, $limit = 0)
{
    if ($needle === null) {
        return splitWithNull($haystack, $limit);
    }

    if (isExpression($needle)) {
        return splitWithExpression($haystack, $needle, $limit);
    }

    return splitWithString($haystack, $needle, $limit);
}