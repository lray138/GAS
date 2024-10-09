<?php 

use function lray138\GAS\DateTime\getDurationString;

it('calculates duration string with years, months, days, hours, minutes, and seconds correctly', function () {
    // Example start and end times
    $start = new DateTime('2024-07-01 12:00:00');
    $end = new DateTime('2025-08-05 14:15:30');

    // Call the function to get the duration string
    $durationString = getDurationString($start, $end);

    // Expected duration string
    $expectedDuration = '1 year, 1 month, 4 days, 2 hours, 15 minutes, 30 seconds'; // Example for the given start and end times

    // Assert that the calculated duration string matches the expected result
    expect($durationString)->toBe($expectedDuration);
});

it('handles durations with only years and months correctly', function () {
    // Example start and end times
    $start = new DateTime('2024-07-01 12:00:00');
    $end = new DateTime('2025-08-01 12:00:00');

    // Call the function to get the duration string
    $durationString = getDurationString($start, $end);

    // Expected duration string
    $expectedDuration = '1 year, 1 month'; // Example for the given start and end times

    // Assert that the calculated duration string matches the expected result
    expect($durationString)->toBe($expectedDuration);
});

it('handles durations with only days correctly', function () {
    // Example start and end times
    $start = new DateTime('2024-07-01 12:00:00');
    $end = new DateTime('2024-07-05 12:00:00');

    // Call the function to get the duration string
    $durationString = getDurationString($start, $end);

    // Expected duration string
    $expectedDuration = '4 days'; // Example for the given start and end times

    // Assert that the calculated duration string matches the expected result
    expect($durationString)->toBe($expectedDuration);
});

it('handles durations with only hours and minutes correctly', function () {
    // Example start and end times
    $start = new DateTime('2024-07-01 12:00:00');
    $end = new DateTime('2024-07-01 14:30:00');

    // Call the function to get the duration string
    $durationString = getDurationString($start, $end);

    // Expected duration string
    $expectedDuration = '2 hours, 30 minutes'; // Example for the given start and end times

    // Assert that the calculated duration string matches the expected result
    expect($durationString)->toBe($expectedDuration);
});

it('handles durations with only seconds correctly', function () {
    // Example start and end times
    $start = new DateTime('2024-07-01 12:00:00');
    $end = new DateTime('2024-07-01 12:00:10');

    // Call the function to get the duration string
    $durationString = getDurationString($start, $end);

    // Expected duration string
    $expectedDuration = '10 seconds'; // Example for the given start and end times

    // Assert that the calculated duration string matches the expected result
    expect($durationString)->toBe($expectedDuration);
});