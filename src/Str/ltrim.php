<?php namespace lray138\GAS\Str;

const ltrim = __NAMESPACE__ . '/ltrim';

function ltrim() {
    $f = function($needle, $haystack) {
        return \ltrim($haystack, $needle);
    };

    return FP\curry2($f)(...func_get_args());
}