<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry3 as curry;

const slice = __NAMESPACE__ . '\slice';

/**
 * @param array $array
 * @param int   $offset
 * @param int   $limit
 *
 * @return array
 */
function slice() {

    $args = func_get_args();

    if(count($args) == 1) {
        $offset = $args[0];
        return function($length_or_array, array $array = null) use ($offset) {
            $args = func_get_args();

            if(count($args) == 2) {
                return array_slice($array, $offset, $length_or_array);
            } else if (is_array($length_or_array)) {
                return array_slice($length_or_array, $offset);
            } else {
                $limit = $args[0];
                return function(array $array) use ($limit, $offset) {
                    return array_slice($array, $offset, $limit);
                };
            }
        };

    } else if(count($args) == 2) {

        if(is_array($args[1])) {
            return array_slice($args[1], $args[0]);
        } else {

            $offset = $args[0];
            $limit = $args[1];

            return function(array $array) use ($offset, $limit){
                return array_slice($array, $offset, $limit);
            };
        }

    } else if(count($args) === 3) {

        return array_slice($args[2], $args[0], $args[1]);
    }

    // $slice = function($offset, $length_or_array = 0, array $array = null) {
    //     if ($limit == 0) {
    //         return array_slice($array, $offset);
    //     }

    //     if (is_array($length_or_array)) {
    //         return array_slice($array, $offset);
    //     }

    //     return array_slice($array, $offset, $limit);
    // };

    // return curry($slice)(...func_get_args());
}