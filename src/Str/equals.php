<?php namespace lray138\GAS\Str;

const equals = __NAMESPACE__ . '\equals';

use function lray138\GAS\Functional\curry2;

/**
 * 
 */
function equals(string $compare, string $to = "") {
    $f = function($compare, $to): bool {
        return $compare === $to;
    };

    return curry2($f)(...func_get_args());
}