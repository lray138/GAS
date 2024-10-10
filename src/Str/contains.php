<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const contains = __NAMESPACE__ . '\contains';

/**
 * @note: looks like this should be simply str_contains and not
 * then contains any and contains all...
 */
function contains() {
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

    return curryN(2)($contains)(...func_get_args());
}