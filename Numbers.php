<?php

namespace GAS\Functions\Numbers;

// https://stackoverflow.com/questions/69262/is-there-an-easy-way-in-net-to-get-st-nd-rd-and-th-endings-for-number/69284#69284
// https://stackoverflow.com/questions/3109978/display-numbers-with-ordinal-suffix-in-php
function ordinal($num) {
    $ones = $num % 10;
    $tens = floor($num / 10) % 10;
    if ($tens == 1) {
        $suff = "th";
    } else {
        switch ($ones) {
            case 1 : $suff = "st"; break;
            case 2 : $suff = "nd"; break;
            case 3 : $suff = "rd"; break;
            default : $suff = "th";
        }
    }
    return $num . $suff;
}

const ordinal = __NAMESPACE__ . '\ordinal';

function padZeroRight($num) {
    return number_format($num, 2);
}

const padZeroRight = __NAMESPACE__ . '\padZeroRight';