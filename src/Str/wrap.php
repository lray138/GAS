<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const wrap = __NAMESPACE__ . '/wrap';

function wrap() {
    $wrap = function($a, $b, $c) {
        return $a . $c . $b;
    };

    return call_user_func_array(curryN(3)($wrap), func_get_args());
}