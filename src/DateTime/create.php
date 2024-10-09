<?php namespace lray138\GAS\DateTime;

/**
 * 
 */
function create($val = null) {
    // If no value is provided, return the current date and time
    if (is_null($val)) {
        return new \DateTime();
    }

    // If the value is an integer, assume it's a timestamp and create a DateTime object from it
    if (is_int($val)) {
        return (new \DateTime())->setTimestamp($val);
    }

    // If the value is a string, attempt to create a DateTime object from it
    if (is_string($val)) {
        try {
            return new \DateTime($val);
        } catch (\Exception $e) {
            // Handle the case where the string is not a valid date/time format
            throw new \InvalidArgumentException("Invalid date/time format: $val");
        }
    }

    // If the value is neither an integer nor a string, throw an exception
    throw new \InvalidArgumentException("Invalid input type. Expected int or string.");
}