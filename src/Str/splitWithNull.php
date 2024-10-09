<?php namespace lray138\GAS\Str;


const splitWithNull = __NAMESPACE__ . '/splitWithNull';

/**
 * @param string $haystack
 * @param int    $limit
 * @todo no clue what this is about
 * @return array
 */
function splitWithNull($haystack, $limit = 0)
{
    if ($limit === 0) {
        return str_split($haystack);
    }

    return str_split($haystack, $limit);
}