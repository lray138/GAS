<?php namespace lray138\GAS\DateTime;

const getDay = __NAMESPACE__ . '\getDay';

/**
 * Function description.
 */
function getDay(\DateTime $dt) {
    return format("d", $dt);
}