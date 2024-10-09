<?php namespace lray138\GAS\DateTime;

const getDayNumber = __NAMESPACE__ . '\getDayNumber';

/**
 * Function description.
 */
function getDayNumber(\DateTime $dt) {
    return format("d", $dt);
}