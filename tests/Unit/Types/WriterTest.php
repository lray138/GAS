<?php

use lray138\GAS\Types\Writer;
use lray138\GAS\Types\Monoid;
use lray138\GAS\Types\ArrType as A; // Assuming you have this Monoid implementation
use lray138\GAS\Types\StrType as S;
use function lray138\GAS\Functional\curryN;
use function lray138\GAS\Math\{add, mul};

it('can create a writer with a value and an empty monoid', function () {
    $writer = Writer::of(5, A::mempty());

    list($value, $log) = $writer->run();

    expect($value)->toBe(5);
    expect($log->extract())->toBe(A::mempty()->extract());
});

it('can map over the value in the writer without affecting the log', function () {
    $monoid = A::of([]); // Assuming you have an ArrType Monoid
    $writer = Writer::of(10, $monoid);

    $mappedWriter = $writer->map(fn($x) => $x * 2);

    list($value, $log) = $mappedWriter->run();

    expect($value)->toBe(20);
    expect($log->extract())->toBe($monoid::mempty()->extract());
});

it('can chain writers and concatenate logs', function () {
    // First writer with value 10 and empty log
    $writer = Writer::of(10, A::of([]));

    // Chain a new writer, adding logs
    $chainedWriter = $writer->bind(function ($x) {
        return Writer::tell(A::of(["Log entry"]))->map(fn() => $x * 2);
    });

    list($value, $log) = $chainedWriter->run();

    expect($value)->toBe(20);
    expect($log->extract())->toBe(["Log entry"]);
});

it('can chain writers and concatenate logs 2', function () {
    // First writer with value 10 and empty log
    $writer = Writer::of(10, A::of([]));

    // Function to create a writer with logging
    $maplog = curryN(3, function ($map, $log, $x) {
        return Writer::tell(A::of([$log]))->map(fn() => $map($x));
    });

    // Chain a new writer, adding logs
    $chainedWriter = $writer
        ->bind($maplog(mul(2), "Multiply By Two")) 
        ->bind($maplog(add(5), "Add 5"))
        ->bind($maplog(mul(2), "Multiply By Two"));

    list($value, $log) = $chainedWriter->run();

    expect($value)->toBe(50); // Final value should be 40
    expect($log->extract())->toBe(["Multiply By Two", "Add 5", "Multiply By Two"]); // Log entries
});

it('can use tell to log a message', function () {
    $writer = Writer::tell(S::of("Log message"));

    list($value, $log) = $writer->run();

    expect($value)->toBeNull();
    expect($log->extract())->toBe("Log message");
});

it('can apply a writer using ap', function () {
    $monoid = A::of([]); // Assuming you have an ArrType Monoid

    $writer1 = Writer::of(fn($x) => $x * 2, $monoid);
    $writer2 = Writer::of(10, $monoid);

    $appliedWriter = $writer1->ap($writer2);

    list($value, $log) = $appliedWriter->run();

    expect($value)->toBe(20);
    expect($log->extract())->toBe($monoid::mempty()->extract());
});