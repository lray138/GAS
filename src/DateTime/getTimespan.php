<?php namespace lray138\GAS\DateTime;

const getTimespan = __NAMESPACE__ . '\getTimespan';

/**
 * Function description.
 */
function getTimespan(\DateTime $start, \DateTime $end, $options = []): string {
    $defaults = [
        "month" => getMMMChar(),
        "year" => "Y",
        "day" => getDChar()
    ];

    $getValue = function($val) use ($options, $defaults) {
        return isset($options[$val])
            ? $options[$val]
            : $defaults[$val];
    };

    $init = FP\curry2(function($bit, $date) use ($getValue) {
        return $date->format($getValue($bit));
    });

    $month = $init("month");
    $year = $init("year");
    $day = $init("day");

    if($year($start) === $year($end)) {
        if($month($start) === $month($end)) {
            if($day($start) === $day($end)) {
                return $month($start) . " " . $day($start) . ", ". $year($start);
            }
            return isset($options["no_days"]) && $options["no_days"] == true
                    ? $month($start) . " " . $year($end)
                    : $month($start) . " " . $day($start) . " - " . $day($end) . ", " . $year($end);
        } else {
            return $month($start) . " " . $day($start) . " - " . $month($end) . " " . $day($end) . ", " . $year($end);
        }
    } else {
        return FP\compose(
            Arr\join(" - "),
            Arr\map(function(\DateTime $d) use ($month, $day, $year) {
                return $month($d) . " " . $day($d) . ", " . $year($d);
            })
        )([$start, $end]);
    }
    return "";
}