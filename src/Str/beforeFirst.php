<?php namespace lray138\GAS\Str;

const beforeFirst = __NAMESPACE__ . '\beforeFirst';

function beforeFirst() {
    $f = function($needle, $haystack) {
        return FP\compose(
            Arr\head,
            Arr\filterEmpty,
            explode($needle)
        )($haystack);
    };

    return curry2($f)(...func_get_args());
}