<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const rtrim = __NAMESPACE__ . '/rtrim';

function rtrim() {
    $f = function($needle, $haystack) {
        return \rtrim($haystack, $needle);
    };
    return curryN(2)($f)(...func_get_args());
}