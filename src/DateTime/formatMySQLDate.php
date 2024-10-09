<?php namespace lray138\GAS\DateTime;

const formatMySQLDate = __NAMESPACE__ . '\formatMySQLDate';

/**
 * Function description.
 */
function formatMySQLDate(\DateTime $dt) {
    return $dt->format("Y-m-d");
}