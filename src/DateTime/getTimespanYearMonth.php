<?php namespace lray138\GAS\DateTime;

const getTimespanYearMonth = __NAMESPACE__ . '\getTimespanYearMonth';

/**
 * Function description.
 */
function getTimespanYearMonth($earliest_date, $latest_date): array {
    $limit = addTime("1 month", $latest_date);
    $out = [];
    do {
        if(!isset($out[$earliest_date->format("Y")])) {
            $out[$earliest_date->format("Y")] = [
                "year" => $earliest_date->format("Y"),
                "months" => []
            ];
        }
        $out[$earliest_date->format("Y")]["months"][] = formatMM($earliest_date);
        $earliest_date = addTime("1 month", $earliest_date);
    } while($earliest_date->format("Y-m") != $limit->format("Y-m"));
    return $out;
}