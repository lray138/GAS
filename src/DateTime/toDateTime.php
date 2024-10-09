<?php namespace lray138\GAS\DateTime;

const toDateTime = __NAMESPACE__ . '\toDateTime';

/**
 * Function description.
 */
function toDateTime($var) {
    if($var instanceof \DateTime) return $var;
    // assume timestamp
    if(is_int($var)) return (new \DateTime())->setTimestamp($var);
}