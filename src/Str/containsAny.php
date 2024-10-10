<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const containsAny = __NAMESPACE__ . '\containsAny';

/**
 * Checks if any of the specified needles are present in the haystack.
 *
 * @param string|string[] $needle The string or array of strings to search for.
 * @param string|string[] $haystack The string or array of strings to search within.
 * @todo change 'needle' to 'find' and haystack to 'source' or something
 * @return bool True if any needle is found in the haystack, otherwise false.
 */
function containsAny() {
    $f = function(array $needles, string $haystack) {
        // this is from PHP docs, although I'd use '$c' for the carry
        return array_reduce($needles, fn($a, $n) => $a || str_contains($haystack, $n), false);
    };

    return curryN(2)($f)(...func_get_args());
}

function containsAny_OLD() {
    $contains = function($needle, string $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) !== false) {
                    return true;
                }
            }
            return false;
        }

        return strpos($haystack, $needle) !== false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}