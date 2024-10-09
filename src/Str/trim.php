<?php namespace lray138\GAS\Str;

const trim = __NAMESPACE__ . '/trim';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 * updating on Sat FEB 18, 2022, cause this is backwards actually
 */
function trim() {
    $f = function($needle, $haystack) {
        if (isExpression($needle)) {
            return trimWithExpression($haystack, $needle);
        }

        return trimWithString($needle, $haystack);
    };

    return FP\curry2($f)(...func_get_args());
}