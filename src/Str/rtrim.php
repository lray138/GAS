<?php namespace lray138\GAS\Str;

const rtrim = __NAMESPACE__ . '/rtrim';

function rtrim() {
    $f = function($needle, $haystack) {
        return \rtrim($haystack, $needle);
    };
    return FP\curry2($f)(...func_get_args());
}