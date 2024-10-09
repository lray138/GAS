<?php namespace lray138\GAS\Arr;

const addIndexKey = __NAMESPACE__ . '\addIndexKey';

/**
 * @todo seems like this could be removed
 */
function addIndexKey(array $data) {
    // dump(array_flip(array_fill_keys(
    //     range(0, count(array_values($data)))
    //     , "index"
    // )));
    return $data;
}