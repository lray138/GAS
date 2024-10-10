<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const beforeLast = __NAMESPACE__ . '\beforeLast';

// added trim right so that I can .. hmmm...
// Oct 10 2024 00:09 - assuming trim right was for ???
function beforeLast() {
    $f = function($substring, $string, $trim_right = false) {
        $index = \strrpos($string, $substring, 0);
        if($trim_right) {
            $index++;
        }
        return $index === false ? $string : substr($string, 0, $index);
    };

    return curryN(2)($f)(...func_get_args());
}