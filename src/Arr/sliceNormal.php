<?php namespace lray138\GAS\Arr;

const sliceNormal = __NAMESPACE__ . '\sliceNormal';


/**
 * I thought this might have been to not worry about the length,
 * i.e. arity 2... 
 * @todo depricate this
 */

function sliceNormal() {
    return slice(...func_get_args());
}

// /**
//  * @param array $array
//  * @param int   $offset
//  * @param int   $limit
//  *
//  * @return array
//  */
// function sliceNormal(array $array, $offset = 0, $limit = 0)
// {
//     if ($limit == 0) {
//         return array_slice($array, $offset);
//     }

//     return array_slice($array, $offset, $limit);
// }