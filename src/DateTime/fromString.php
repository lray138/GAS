<?php namespace lray138\GAS\DateTime;

const fromString = __NAMESPACE__ . '\fromString';

/**
 * Function description.
 */
function fromString($string) {
    // need a check for timestamp vs.
    // ....
    return is_null($string) ? NULL : new \DateTime($string);
}