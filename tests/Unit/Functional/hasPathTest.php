<?php 

use function lray138\GAS\Functional\toPath;
use function lray138\GAS\Functional\hasPath;

it('returns true if the path exists in the array', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];
    expect(hasPath(['user', 'profile', 'name'], $input))->toBeTrue();
    expect(hasPath('user.profile.name', $input))->toBeTrue();
});

it('returns false if the path does not exist in the array', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];
    
    expect(hasPath(['user', 'profile', 'age'], $input))->toBeFalse();
});

it('returns true if the path exists in the object', function () {
    $input = (object)[
        'user' => (object)[
            'profile' => (object)[
                'name' => 'John Doe',
            ],
        ],
    ];
    expect(hasPath(['user', 'profile', 'name'], $input))->toBeTrue();
});

it('returns false if the path does not exist in the object', function () {
    $input = (object)[
        'user' => (object)[
            'profile' => (object)[
                'name' => 'John Doe',
            ],
        ],
    ];
    expect(hasPath(['user', 'profile', 'age'], $input))->toBeFalse();
});

// it('returns false if an empty path is given', function () {
//     $input = [
//         'user' => [
//             'profile' => [
//                 'name' => 'John Doe',
//             ],
//         ],
//     ];
//     expect(hasPath([], $input))->toBeFalse();
// });

it('supports currying and checks path existence', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];
    $checkUserProfile = hasPath(['user', 'profile']);
    expect($checkUserProfile($input))->toBeTrue();
});

// it('returns false if input is null or not iterable', function () {
//     $input = null;
//     expect(hasPath(['user', 'profile'], $input))->toBeFalse();
// });
