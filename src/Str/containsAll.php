<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN; 

const containsAll = __NAMESPACE__ . '\containsAll';

/**
 *
 */
function containsAll() {
    $f = function(array $needles, string $haystack): bool {
        return array_reduce($needles, fn($a, $n) => $a && str_contains($haystack, $n), true);
    };

    return curryN(2)($f)(...func_get_args());
}

function containsAll_OLD() {
    $contains = function($needle, $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) === false) {
                    return false;
                }
            }
            return true;
        }
        return strpos($haystack, $needle) !== false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}