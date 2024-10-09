<?php namespace lray138\GAS\DateTime;

const fromTimestamp = __NAMESPACE__ . '\fromTimestamp';

/**
 * Function description.
 */
function fromTimestamp($timestamp) {
    if(empty($timestamp)) {
        return null;
    }
    // noticed some old code where you could also do
    // (new DateTime("@" . $timestamp))
    return (new \DateTime())->setTimestamp($timestamp);
}