<?php 

use function lray138\GAS\Arr\sortUserKeys;

it('sorts an array of users by keys using a given callback', function () {
    $users = [
        'user3' => ['name' => 'Doe', 'age' => 40],
        'user1' => ['name' => 'John', 'age' => 30],
        'user2' => ['name' => 'Jane', 'age' => 25]
    ];

    $expected = [
        'user1' => ['name' => 'John', 'age' => 30],
        'user2' => ['name' => 'Jane', 'age' => 25],
        'user3' => ['name' => 'Doe', 'age' => 40]
    ];

    $sortedUsers = sortUserKeys(fn($a, $b) => $a <=> $b, $users);

    expect($sortedUsers)->toBe($expected);
});