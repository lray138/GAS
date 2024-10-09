<?php

use function lray138\GAS\DateTime\modify;

it('modifies the date by adding one day', function () {
    $dt = new DateTime('2023-01-01');
    $result = modify('+1 day', $dt);
    expect($result->format('Y-m-d'))->toBe('2023-01-02');
});

it('modifies the date by subtracting one day', function () {
    $dt = new DateTime('2023-01-01');
    $result = modify('-1 day', $dt);
    expect($result->format('Y-m-d'))->toBe('2022-12-31');
});

it('does not alter the original DateTime object', function () {
    $dt = new DateTime('2023-01-01');
    $original = clone $dt;
    modify('+1 day', $dt);
    expect($dt)->toEqual($original);
});

it('returns a DateTime object when modifying the date', function () {
    $dt = new DateTime('2023-01-01');
    $result = modify('+1 day', $dt);
    expect($result)->toBeInstanceOf(\DateTime::class);
});