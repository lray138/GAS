<?php namespace lray138\GAS\Str;

const append = __NAMESPACE__ . '/append';

use function lray138\GAS\Functional\curryN;

function append() {
    $f = function($append, $to) {
        return concat($to, $append);
    };

    return curryN(2)($f)(...func_get_args());
}