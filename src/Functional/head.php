<?php namespace lray138\GAS\Functional;

const head = __NAMESPACE__ . '\head';

/**
 * Function description.
 */
function head($collection) {
    // when passing the ArrType was choking
    // also, ArrType head is weird because that 
    // should essentially be a "get" or "extract" first element
    // I think I ran into some case where I wanted to continue the chaining
    // which I believe is where "extend" comes into play
    $collection = extract($collection);

    foreach ($collection as $value) {
        return $value;
    }

    return null;
}