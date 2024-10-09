<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2;
use function lray138\GAS\Functional\extract;

const chunk = __NAMESPACE__ . '\chunk';

/**
 * @param int $size
 * @param array $haystack
 * @todo in future we should not be extracting here, that's "cross contamination"
 * @return array
 * 
 * Reference: https://www.php.net/manual/en/function.array-chunk.php
 */
function chunk(int $size, array $array = null) {
    $f = function(int $size, array $array) {
        return array_chunk($array, $size);
    };

    return curry2($f)(...func_get_args());
}