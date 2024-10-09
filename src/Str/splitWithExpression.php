<?php namespace lray138\GAS\Str;

const splitWithExpression = __NAMESPACE__ . '/splitWithExpression';

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $limit
 *
 * @return array
 */
function splitWithExpression($haystack, $needle, $limit = 0)
{
    if ($limit === 0) {
        return preg_split($needle, $haystack);
    }

    return preg_split($needle, $haystack, $limit);
}
