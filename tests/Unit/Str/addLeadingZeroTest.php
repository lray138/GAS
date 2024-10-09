<?php

use function lray138\GAS\Str\addLeadingZero;

it('should add a leading zero to single-digit numbers', function () {
    $number = "5";
    $result = addLeadingZero($number);
    expect($result)->toBe("05");
});

it('should not add a leading zero to two-digit numbers', function () {
    $number = "15";
    $result = addLeadingZero($number);
    expect($result)->toBe("15");
});

it('should work correctly with zero', function () {
    $number = "0";
    $result = addLeadingZero($number);
    expect($result)->toBe("00");
});

it('should not change numbers with leading zeros', function () {
    $number = "09";
    $result = addLeadingZero($number);
    expect($result)->toBe("09");
});