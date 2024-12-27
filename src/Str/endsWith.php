<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const endsWith = __NAMESPACE__ . '\endsWith';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function endsWith() {
    $f = function($needle, $haystack) {
        return isExpression($needle) 
            ? endsWithExpression($needle, $haystack)
            : endsWithString($needle, $haystack);
    };

    return curryN(2)($f)(...func_get_args());
}