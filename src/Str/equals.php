<?php namespace lray138\GAS\Str;

const equals = __NAMESPACE__ . '\equals';

/**
 * 
 */
function equals(string $compare, string $to = "") {
    $f = function($compare, $to): bool {
        return $compare === $to;
    };
    return FP\curryN(2, $f)(...func_get_args());
}