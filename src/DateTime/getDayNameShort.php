<?php namespace lray138\GAS\DateTime;

const getDayNameShort = __NAMESPACE__ . '\getDayNameShort';

/**
 * Function description.
 */
function getDayNameShort(\DateTime $dt) {
    return format("D", $dt);
}