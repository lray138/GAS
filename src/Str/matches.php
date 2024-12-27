<?php namespace lray138\GAS\Str;

// wonder if this is me or not because matches would only indicate a
// regular expression

// also, argumenet order was not correct so wonder how in use this was

use function lray138\GAS\Functional\curryN;

const matches = __NAMESPACE__ . '\matches';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matches() {
    $f = function($needle, $haystack) {
        return isExpression($needle)
            ? matchesExpression($needle, $haystack)
            : matchesString($needle, $haystack);
    };

    return curryN(2)($f)(...func_get_args());
}