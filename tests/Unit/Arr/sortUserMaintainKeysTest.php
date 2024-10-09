<?php 

use function lray138\GAS\Arr\sortUserMaintainKeys;

it('sorts an array of users by a given callback while maintaining keys', function () {
    $users = [
        'user1' => ['name' => 'John', 'age' => 30],
        'user2' => ['name' => 'Jane', 'age' => 25],
        'user3' => ['name' => 'Doe', 'age' => 40]
    ];

    $expected = [
        'user2' => ['name' => 'Jane', 'age' => 25],
        'user1' => ['name' => 'John', 'age' => 30],
        'user3' => ['name' => 'Doe', 'age' => 40]
    ];

    $sortedUsers = sortUserMaintainKeys(fn($a, $b) => $a['age'] <=> $b['age'], $users);

    expect($sortedUsers)->toBe($expected);
});