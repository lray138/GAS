<?php

use function lray138\GAS\DateTime\addTime;

it('adds one day to a DateTime object', function () {
    $dt = new DateTime('2023-01-01');
    $result = addTime('1 day', $dt);
    expect($result->format('Y-m-d'))->toBe('2023-01-02');
});

it('adds one hour to a DateTime object', function () {
    $dt = new DateTime('2023-01-01 12:00:00');
    $result = addTime('1 hour', $dt);
    expect($result->format('Y-m-d H:i:s'))->toBe('2023-01-01 13:00:00');
});

it('adds one minute to a DateTime object', function () {
    $dt = new DateTime('2023-01-01 12:00:00');
    $result = addTime('1 minute', $dt);
    expect($result->format('Y-m-d H:i:s'))->toBe('2023-01-01 12:01:00');
});

it('adds one month to a DateTime object', function () {
    $dt = new DateTime('2023-01-01');
    $result = addTime('1 month', $dt);
    expect($result->format('Y-m-d'))->toBe('2023-02-01');
});

it('adds one year to a DateTime object', function () {
    $dt = new DateTime('2023-01-01');
    $result = addTime('1 year', $dt);
    expect($result->format('Y-m-d'))->toBe('2024-01-01');
});