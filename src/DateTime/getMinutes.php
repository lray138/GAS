<?php namespace lray138\GAS\DateTime;

const getMinutes = __NAMESPACE__ . '\getMinutes';

/**
 * Function description.
 */
function getMinutes(\DateTime $dt) {
    return format("i", $dt);
}