<?php 

use function lray138\GAS\Arr\sortCallback;

it('sorts an array of users by a given callback', function () {
    $users = [
        ['name' => 'John', 'age' => 30],
        ['name' => 'Jane', 'age' => 25],
        ['name' => 'Doe', 'age' => 40]
    ];

    $expected = [
        ['name' => 'Jane', 'age' => 25],
        ['name' => 'John', 'age' => 30],
        ['name' => 'Doe', 'age' => 40]
    ];

    $sortedUsers = sortCallback(fn($a, $b) => $a['age'] <=> $b['age'], $users);

    expect($sortedUsers)->toBe($expected);
});