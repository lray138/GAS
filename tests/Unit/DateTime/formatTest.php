<?php 

use function lray138\GAS\DateTime\format;

it('formats dates correctly for known formats', function () {
    $dt = new DateTime('2024-07-05 12:34:56');

    expect(format('mysql')($dt))->toBe('2024-07-05 12:34:56');
    expect(format('shell')($dt))->toBe('202407051234');
});

it('formats dates using custom format strings', function () {
    $dt = new DateTime('2024-07-05 12:34:56');

    expect(format('Y-m-d H:i:s')($dt))->toBe('2024-07-05 12:34:56');
    expect(format('YmdHis')($dt))->toBe('20240705123456');
});