<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\{compose, curryN};
use lray138\GAS\Arr;

const beforeFirst = __NAMESPACE__ . '\beforeFirst';

function beforeFirst() {
    $f = function($needle, $haystack) {
        return compose(
            Arr\head,
            Arr\filterEmpty,
            explode($needle)
        )($haystack);
    };

    return curryN(2)($f)(...func_get_args());
}