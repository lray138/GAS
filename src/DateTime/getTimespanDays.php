<?php namespace lray138\GAS\DateTime;

const getTimespanDays = __NAMESPACE__ . '\getTimespanDays';

/**
 * Function description.
 */
function getTimespanDays(\DateTime $start, \DateTime $end, $options = []): string {
    // Calculate the difference between the start and end dates
    $interval = $start->diff($end);

    // Extract the number of days from the interval
    $days = $interval->days;

    // Handle any options, if needed
    if (isset($options['format']) && $options['format'] === 'textual') {
        return "{$days} day" . ($days !== 1 ? 's' : '');
    }

    // Return the number of days as a string
    return (string) $days;
}