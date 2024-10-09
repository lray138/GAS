<?php namespace lray138\GAS\DateTime;

const isSameDayOfYear = __NAMESPACE__ . '\isSameDayOfYear';

/**
 * Function description.
 */
function isSameDayOfYear($a, $b) {
    $format = "Y-m-d";
    return $a->format($format) === $b->format($format);
}