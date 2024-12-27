<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const ltrim = __NAMESPACE__ . '/ltrim';

function ltrim() {
    $f = function($needle, $haystack) {
        return \ltrim($haystack, $needle);
    };

    return curryN(2)($f)(...func_get_args());
}