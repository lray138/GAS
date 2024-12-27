<?php 

use function lray138\GAS\Functional\paths;
use lray138\GAS\Types\Maybe\Nothing;
use const lray138\GAS\Functional\extract;

it('returns an array of values for given paths in the array', function () {
    $collection = [
        'user' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ],
        'settings' => [
            'theme' => 'dark',
            'notifications' => true,
        ],
    ];

    $paths = ['user.name', 'settings.theme'];

    $result = paths($paths, $collection)
        ->map(extract)
        ->extract();

    expect($result)->toBe(['John Doe', 'dark']);
});

it('returns an array of values for given paths in the object', function () {
    $collection = (object)[
        'user' => (object)[
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ],
        'settings' => (object)[
            'theme' => 'dark',
            'notifications' => true,
        ],
    ];

    $paths = ['user.name', 'settings.theme'];

    $result = paths($paths, $collection)
        ->map(extract)
        ->extract();

    expect($result)->toBe(['John Doe', 'dark']);
});

it('passes the Idles tests', function() {

    $a = [ 'a' => [ [ 'b' => [ 'c' => 3 ] ], 4] ];
    
    $result = paths([['a',0,'b','c'], ['a',0,'z'], ['a',1]], $a)
        ->map(extract)
        ->extract();

    expect($result)->toBe([3, null, 4]);

    //paths(['a.0.b.c', 'a.0.z', 'a.1'], $a); // [3, null, 4]
});

// it('returns an empty array if the paths do not exist', function () {
//     $collection = [
//         'user' => [
//             'name' => 'John Doe',
//         ],
//     ];

//     $paths = ['user.age', 'settings.language'];

//     $result = paths($paths, $collection);

//     expect($result)->toBe([null, null]); // assuming path() returns null for missing paths
// });

// it('returns values for nested paths in the collection', function () {
//     $collection = [
//         'user' => [
//             'profile' => [
//                 'name' => 'John Doe',
//                 'age' => 30,
//             ],
//         ],
//     ];

//     $paths = ['user.profile.name', 'user.profile.age'];

//     $result = paths($paths, $collection);

//     expect($result)->toBe(['John Doe', 30]);
// });

// it('works with a flattened list of paths', function () {
//     $collection = [
//         'user' => [
//             'name' => 'John Doe',
//         ],
//     ];

//     $result = paths('user.name', $collection);

//     expect($result)->toBe(['John Doe']);
// });

// it('returns an empty array when collection is null', function () {
//     $result = paths('user.name', null);

//     expect($result)->toBe([null]); // assuming collect(null) handles this gracefully
// });
