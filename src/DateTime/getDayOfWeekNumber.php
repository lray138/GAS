<?php namespace lray138\GAS\DateTime;

const getDayOfWeekNumber = __NAMESPACE__ . '\getDayOfWeekNumber';

/**
 * Function description.
 */
function getDayOfWeekNumber(\DateTime $dt) {
    return $dt->format("w");
}