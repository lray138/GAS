<?php namespace lray138\GAS\Functional;

const Just = __NAMESPACE__ . '\Just';

/**
 * Function description.
 */
function Just($value) {
    return Maybe::of($value);
}