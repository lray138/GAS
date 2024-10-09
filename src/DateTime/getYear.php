<?php namespace lray138\GAS\DateTime;

const getYear = __NAMESPACE__ . '\getYear';

/**
 * Function description.
 */
function getYear(\DateTime $dt) {
    return format("Y", $dt);
}