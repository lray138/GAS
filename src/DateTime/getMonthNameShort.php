<?php namespace lray138\GAS\DateTime;

const getMonthNameShort = __NAMESPACE__ . '\getMonthNameShort';

/**
 * Function description.
 */
function getMonthNameShort(\DateTime $dt) {
    return format("M", $dt);
}