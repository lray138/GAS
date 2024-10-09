<?php

use function lray138\GAS\DateTime\create;

// it('returns a DateTime object when an integer (timestamp) is provided', function () {
//     $timestamp = 1672531199; // Example timestamp
//     $result = create($timestamp);
//     $compare = (new \DateTime())->setTimestamp($timestamp);
//     expect($compare->getTimestamp())->toBe($result->getTimestamp());
// });

it('returns the current DateTime when no value is provided', function () {
    $result = create();
    expect($result)->toBeInstanceOf(\DateTime::class);
});

it('returns a DateTime object when an integer (timestamp) is provided', function () {
    $timestamp = 1672531199; // Example timestamp
    $result = create($timestamp);
    $compare = (new \DateTime())->setTimestamp($timestamp);
    expect($result)->toBeInstanceOf(\DateTime::class)
                   ->and($compare->getTimestamp())->toBe($result->getTimestamp());
});

it('returns a DateTime object when a valid date string is provided', function () {
    $dateString = '2024-07-05 12:34:56';
    $result = create($dateString);
    expect($result)->toBeInstanceOf(\DateTime::class)
                   ->and($result->format('Y-m-d H:i:s'))->toBe('2024-07-05 12:34:56');
});

it('throws an InvalidArgumentException for an invalid date string', function () {
    expect(fn() => create('invalid-date'))->toThrow(\InvalidArgumentException::class);
});

it('throws an InvalidArgumentException for an invalid input type', function () {
    expect(fn() => create([]))->toThrow(\InvalidArgumentException::class);
});

it('parses various valid date formats', function () {
    $formats = [
        '2024-07-05' => '2024-07-05 00:00:00',
        '2024-07-05T12:34:56' => '2024-07-05 12:34:56',
        //'2024-07-05T12:34:56+02:00' => '2024-07-05 10:34:56', // UTC conversion
        // 'Mon, 15 Aug 2005 15:52:01 +0000' => '2005-08-15 15:52:01',
        // '05-07-2024' => '2024-07-05 00:00:00',
        // '07/05/2024' => '2024-07-05 00:00:00',
        // '2024/07/05' => '2024-07-05 00:00:00',
        // '2024-07-05 12:34:56' => '2024-07-05 12:34:56',
        // '05-07-2024 12:34:56' => '2024-07-05 12:34:56',
        // '07/05/2024 12:34:56' => '2024-07-05 12:34:56',
        // '1672531199' => '2023-01-01 00:59:59',
    //     'now' => (new \DateTime())->format('Y-m-d H:i:s'),
    //     'today' => (new \DateTime('today'))->format('Y-m-d 00:00:00'),
    //     'tomorrow' => (new \DateTime('tomorrow'))->format('Y-m-d 00:00:00'),
    //     'yesterday' => (new \DateTime('yesterday'))->format('Y-m-d 00:00:00'),
    //     'first day of this month' => (new \DateTime('first day of this month'))->format('Y-m-d 00:00:00'),
    //     'last day of next month' => (new \DateTime('last day of next month'))->format('Y-m-d 00:00:00'),
    //     'next Monday' => (new \DateTime('next Monday'))->format('Y-m-d 00:00:00'),
    ];

    foreach ($formats as $input => $expected) {
        $result = create($input);
        expect($result)->toBeInstanceOf(\DateTime::class);
        expect($result->format('Y-m-d H:i:s'))->toBe($expected);
    }
});

it('parses ISO 8601 date format with timezone offset', function () {
    $dateString = '2024-07-05T12:34:56+02:00';
    $result = create($dateString);
    expect($result)->toBeInstanceOf(\DateTime::class);
    expect($result->format('Y-m-d H:i:s P'))->toBe('2024-07-05 12:34:56 +02:00');
});
