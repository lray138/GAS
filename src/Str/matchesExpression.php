<?php namespace lray138\GAS\Str;

const matchesExpression = __NAMESPACE__ . '\matchesExpression';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matchesExpression($haystack, $needle)
{
    //preg_match(pattern, subject)
    if (preg_match($haystack, $needle)) {
        return true;
    }

    return false;
}