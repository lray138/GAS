<?php namespace lray138\GAS\DateTime;

const roundToNearestMinuteInterval = __NAMESPACE__ . '\roundToNearestMinuteInterval';

/**
 * Round minutes to the nearest interval of a DateTime object.
 * 
 * @param \DateTime $dateTime
 * @param int $minuteInterval
 * @return \DateTime
 */
// https://ourcodeworld.com/articles/read/756/how-to-round-up-down-to-nearest-10-or-5-minutes-of-datetime-in-php
function roundToNearestMinuteInterval() {
    $round = function($minuteInterval, \DateTime $dateTime) {
        return $dateTime->setTime($dateTime->format('H')
                                , round(($dateTime->format("i") + ($dateTime->format("s") / 60)) / $minuteInterval) * $minuteInterval
                                , 0);
    };

    return call_user_func_array(FP\curry2($round), func_get_args());
}