<?php namespace lray138\GAS\DateTime;

const roundDownToMinuteInterval = __NAMESPACE__ . '\roundDownToMinuteInterval';

/**
 * Round down minutes to the nearest lower interval of a DateTime object.
 * 
 * @param \DateTime $dateTime
 * @param int $minuteInterval
 * @return \DateTime
 */
function roundDownToMinuteInterval(\DateTime $dateTime, $minuteInterval = 10) {
    return $dateTime->setTime($dateTime->format('H'),
        floor($dateTime->format('i') / $minuteInterval) * $minuteInterval, 0);
}