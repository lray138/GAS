<?php namespace lray138\GAS\Str;

const slice = __NAMESPACE__ . '/slice';

/**
 * @param string $string
 * @param int    $offset
 * @param int    $limit
 *
 * @return string
 */
function slice($string, $offset = 0, $limit = 0)
{
    if ($limit == 0) {
        return substr($string, $offset);
    }

    return substr($string, $offset, $limit);
}