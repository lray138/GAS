<?php namespace lray138\GAS\DateTime;

const niceDiffFormat = __NAMESPACE__ . '\niceDiffFormat';

/**
 * Function description.
 */
function niceDiffFormat($a, $b, $options = []) {
    $a = toDateTime($a);
    $b = toDateTime($b);

    $delimeter = isset($options["delimeter"]) ? $options["delimeter"] : " ";

    if(is_null($a) || is_null($b)) {
        return "Problem with provided dates";
    }

    $interval = date_diff($a, $b);
 
    if(!$interval) {
        return "false";
    }

    $map = [
        "y" => "years"
        , "m" => "months"
        , "d" => "days"
        , "h" => "hours"
        , "i" => "minutes"
        , "s" => "seconds"
    ];

    $filtered = array_reduce(array_keys($map), function($carry, $x) use ($delimeter, $map, $interval) {
        $formatted = $interval->format("%" . $x);
        // we know it's a string so "=="
        if($formatted == 0) return $carry;

        $field = $formatted < 2
            ? substr($map[$x], 0, strlen($map[$x])-1)
            : $map[$x];

        $carry[] = $formatted . " " . $field;
        return $carry;
    }, []);

    return implode($delimeter, $filtered);

    // $out = [];
    // array_walk(array_keys($map), function($x) use ($interval, &$out) {
    //  $format = $interval->format("%" . $x);
    //  if($format != 0) {
    //      $out[$x] = $format;
    //  }
    // });

    // $out2 = [];
    // array_walk($out, function($x, $y) use (&$out2, $map) {
    //  $field = $x < 2
    //      ? substr($map[$y], 0, strlen($map[$y])-1)
    //      : $map[$y];
        
    //  $out2[] = $x . " " . $field;
    // });

    // return implode($delimeter, $out2);
}