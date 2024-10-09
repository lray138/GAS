<?php namespace lray138\GAS\DateTime;

const formatMM = __NAMESPACE__ . '\formatMM';

/**
 * Function description.
 */
function formatMM(\DateTime $dt) {
    return $dt->format("m");
}