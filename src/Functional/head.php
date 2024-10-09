<?php namespace lray138\GAS\Functional;

const head = __NAMESPACE__ . '\head';

/**
 * Function description.
 */
function head($collection) {
    foreach ($collection as $value) {
        return $value;
    }

    return null;
}