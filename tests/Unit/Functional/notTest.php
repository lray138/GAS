<?php 

use function lray138\GAS\Functional\not;

it('returns true when input is false', function () {
    $input = false;
    $result = not($input);
    expect($result)->toBeTrue();
});

it('returns false when input is true', function () {
    $input = true;
    $result = not($input);
    expect($result)->toBeFalse();
});

it('handles multiple true inputs correctly', function () {
    $input1 = true;
    $input2 = true;
    $result1 = not($input1);
    $result2 = not($input2);
    expect($result1)->toBeFalse();
    expect($result2)->toBeFalse();
});

it('handles multiple false inputs correctly', function () {
    $input1 = false;
    $input2 = false;
    $result1 = not($input1);
    $result2 = not($input2);
    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();
});