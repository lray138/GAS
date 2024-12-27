<?php 

use function lray138\GAS\Functional\collect;

it('returns an empty array when passed null', function () {
    expect(collect(null))->toBe([]);
});

it('returns the array when passed an array', function () {
    $array = [1, 2, 3];
    expect(collect($array))->toBe($array);
});

it('converts an iterable to an array', function () {
    $iterable = new ArrayIterator([1, 2, 3]);
    expect(collect($iterable))->toBe([1, 2, 3]);
});

it('returns an empty array when passed an empty iterable', function () {
    $iterable = new ArrayIterator([]);
    expect(collect($iterable))->toBe([]);
});

it('handles a generator correctly', function () {
    $generator = (function () {
        yield 1;
        yield 2;
        yield 3;
    })();
    
    expect(collect($generator))->toBe([1, 2, 3]);
});

it('throws an error when passed a non-iterable or non-array value', function () {
    expect(fn() => collect(123))->toThrow(TypeError::class);
});
