<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const merge = __NAMESPACE__ . '\merge';

/**
 * @param array $array
 * @param array $merge
 *
 * @return array
 */
function merge(array $merge, array $with = null) {
    $f = function(array $merge, array $with) {
        return array_merge($with, $merge);
    };

    return curry($f)(...func_get_args());
}

// original left for example, will clean up later
function merge_() {
    $f = function($merge, $with) {
        // if($with instanceof ArrType) {
        //    return $with->merge($merge);
        // }

        $with = FP\extract($with);
        $merge = FP\extract($merge);

        if(is_null($merge)) {
            return $with;
        }

        return array_merge($with, $merge);
    };

    return FP\curry2($f)(...func_get_args());
}