<?php namespace lray138\GAS\Math;

use function lray138\GAS\Functional\curryN;

const divideBy = __NAMESPACE__ . '\divideBy';

function divideBy() {
    $f = function($x, $y) {
        return $y / $x;
    };

    return curryN(2, $f)(...func_get_args());
}