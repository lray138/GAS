<?php namespace lray138\GAS\DateTime;

const getDayNames = __NAMESPACE__ . '\getDayNames';

function getDayNames($first_day = "Sunday") {
    return [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
        ];
}

function getDayNamesShort() {
    return array_map(function ($day) {
        return substr($day, 0, 3);
    }, getDayNames());
}