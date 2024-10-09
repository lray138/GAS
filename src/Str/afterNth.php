<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry3 as curry;

const afterNth = __NAMESPACE__ . '\afterNth';

/**
 * @todo this should be named 'afterNthDelimiter' for clarity
 * Note: if delimeter not found explode returns NULL
 * Note: I also hadn't implemented my curried explode so it was returning null.
 */
function afterNth() {
    $f = function($n, $delimiter, $string) {
        // only check 'strpos' if $n === -1
        if($n === -1 && strpos($string, $delimiter) === false) {
            return "";
        }

        $bits = \explode($delimiter, $string);
        $sliced = array_slice($bits, $n);
        return implode($delimiter, $sliced);
    };

    return curry($f)(...func_get_args());
}