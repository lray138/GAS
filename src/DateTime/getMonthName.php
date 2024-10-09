<?php namespace lray138\GAS\DateTime;

const getMonthName = __NAMESPACE__ . '\getMonthName';

/**
 * Function description.
 */
function getMonthName(\DateTime $dt) {
    return format("F", $dt);
}