<?php namespace lray138\GAS\DateTime;

const fromUTCString = __NAMESPACE__ . '\fromUTCString';

/**
 * Function description.
 */
function fromUTCString(string $utcTimestamp) {
    return new \DateTime($utcTimestamp, new \DateTimeZone('UTC'));
}