<?php namespace lray138\GAS\DateTime;

const getDayName = __NAMESPACE__ . '\getDayName';

/**
 * Function description.
 */
function getDayName(\DateTime $dt) {
    return format("l", $dt);
}