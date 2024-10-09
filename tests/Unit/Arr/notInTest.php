<?php 

use function lray138\GAS\Arr\notIn;
use function lray138\GAS\Functional\not;
use function lray138\GAS\Arr\contains;


it('returns true when the needle is not in the haystack', function () {
    $haystack = [1, 2, 3, 4, 5];
    $needle = 6;
    expect(notIn($needle, $haystack))->toBeTrue();
    expect(contains($needle, $haystack))->toBeFalse();
    expect(not(contains($needle, $haystack)))->toBeTrue();
});

it('returns false when the needle is in the haystack', function () {
    $haystack = [1, 2, 3, 4, 5];
    $needle = 3;
    expect(notIn($needle, $haystack))->toBeFalse();
});

it('returns true when the haystack is empty', function () {
    $haystack = [];
    $needle = 1;
    expect(notIn($needle, $haystack))->toBeTrue();
});

it('returns true when the needle is null and not in the haystack', function () {
    $haystack = [1, 2, 3];
    $needle = null;
    expect(notIn($needle, $haystack))->toBeTrue();
});

it('returns false when the needle is null and in the haystack', function () {
    $haystack = [1, 2, 3, null];
    $needle = null;
    expect(notIn($needle, $haystack))->toBeFalse();
});

it('handles mixed types in the haystack', function () {
    $haystack = [1, 'two', 3.5, true];
    $needle1 = 'two';
    $needle2 = false;
    expect(notIn($needle1, $haystack))->toBeFalse();
    expect(notIn($needle2, $haystack))->toBeTrue();
});