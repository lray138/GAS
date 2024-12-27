<?php 

use function lray138\GAS\Functional\path;
use lray138\GAS\Types\Maybe\Nothing;

it('retrieves a value from an array using a valid path', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];

    $expected = 'John Doe';
    $result = path(['user', 'profile', 'name'], $input);
    
    expect($result->extract())->toBe($expected);
    expect($result->get())->toBe($expected);
});

it('returns Nothing if the path does not exist in an array', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];
    expect(path(['user', 'profile', 'age'], $input))->toBeInstanceOf(Nothing::class);
});

it('retrieves a value from an object using a valid path', function () {
    $input = (object)[
        'user' => (object)[
            'profile' => (object)[
                'name' => 'John Doe',
            ],
        ],
    ];

    $result = path(['user', 'profile', 'name'], $input);
    $expected = 'John Doe';

    expect($result->get())->toBe($expected);
});

it('returns Nothing if the path does not exist in an object', function () {
    $input = (object)[
        'user' => (object)[
            'profile' => (object)[
                'name' => 'John Doe',
            ],
        ],
    ];

    $result = path(['user', 'profile', 'age'], $input);

    expect($result)->toBeInstanceOf(Nothing::class);
});

// it('returns the default value when the record is null', function () {
//     $input = null;
//     expect(path(['user', 'profile', 'name'], $input, 'Default Value'))->toBe('Default Value');
// });

it('supports string paths with dot notation', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];

    $result = path('user.profile.name', $input);
    $expected = 'John Doe';

    expect($result->extract())->toBe('John Doe');
});

it('returns Nothing if string path with dot notation does not exist', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];

    expect(path('user.profile.age', $input))->toBeInstanceOf(Nothing::class);
});

it('supports currying for path lookup', function () {
    $input = [
        'user' => [
            'profile' => [
                'name' => 'John Doe',
            ],
        ],
    ];

    $getUserProfile = path(['user', 'profile']);
    $result = $getUserProfile($input);

    expect($result->get())->toBe(['name' => 'John Doe']);
});
