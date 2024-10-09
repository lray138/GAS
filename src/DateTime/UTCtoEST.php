<?php namespace lray138\GAS\DateTime;

const UTCtoEST = __NAMESPACE__ . '\UTCtoEST';

/**
 * Function description.
 * NOTE:  this doesn't really make sense because I would think I'd want it 
 * as a DateTime input???? Wondering how I used this originally... looks like
 * it was wrike api token, but this would be a good example of composition
 */
function UTCtoEST(string $utcTimestamp) : \DateTime {
    // Create a DateTime object with the UTC timestamp and set the timezone to UTC
    $dateTimeUtc = new \DateTime($utcTimestamp, new \DateTimeZone('UTC'));
    // Set the timezone to Eastern Standard Time (EST)
    $dateTimeUtc->setTimezone(new \DateTimeZone('America/New_York'));
    return $dateTimeUtc;
}