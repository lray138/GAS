<?php namespace lray138\GAS\Str;

const append = __NAMESPACE__ . '/append';

function append() {
    $append = function($append, $to) {
        return concat($to, $append);
    };

    return call_user_func_array(curry2($append), func_get_args());
}