<?php 

use function lray138\GAS\DateTime\UTCtoEST;

it('converts UTC timestamp to EST correctly', function () {
    // Example UTC timestamp
    $utcTimestamp = '2024-07-05 12:00:00';

    // Call the function to convert UTC to EST
    $dateTimeEst = UTCtoEST($utcTimestamp);

    // Expected EST time in ISO 8601 format
    $expectedEstTime = '2024-07-05T08:00:00-04:00'; // Example offset for EST (-04:00)

    // Assert that the converted DateTime object has the expected timestamp
    expect($dateTimeEst->format('c'))->toBe($expectedEstTime);
});