<?php namespace lray138\GAS\Functional;

const pipe = __NAMESPACE__ . '\pipe';

/**
 * Function description.
 */
// could almost remove this...
function pipe(...$functions) {
    return compose(...array_reverse($functions));
}