<?php 
declare(strict_types=1);

namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry2;

const containsNone = __NAMESPACE__ . '\containsNone';

/**
 * @param string|array $needle
 * @param string $haystack
 * @return bool
 */
function containsNone(): bool 
{
    $contains = function($needle, $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) !== false) {
                    return false;
                }
            }
            return true;
        }

        if(empty($needle) || empty($haystack)) {
            return true;
        }

        return strpos($haystack, $needle) === false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}