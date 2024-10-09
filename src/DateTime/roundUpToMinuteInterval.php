<?php namespace lray138\GAS\DateTime;

const roundUpToMinuteInterval = __NAMESPACE__ . '\roundUpToMinuteInterval';

/**
 * Round up minutes to the nearest upper interval of a DateTime object.
 * 
 * @param \DateTime $dateTime
 * @param int $minuteInterval
 * @return \DateTime
 */
function roundUpToMinuteInterval(\DateTime $dateTime, $minuteInterval = 10) {
    return $dateTime->setTime(
        $dateTime->format('H'),
        ceil($dateTime->format('i') / $minuteInterval) * $minuteInterval,
        0
    );
}