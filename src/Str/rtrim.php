<?php namespace lray138\GAS\Str;

use lray138\GAS\Functionl\curry2;

const rtrim = __NAMESPACE__ . '/rtrim';

function rtrim() {
    $f = function($needle, $haystack) {
        return \rtrim($haystack, $needle);
    };
    return curry2($f)(...func_get_args());
}