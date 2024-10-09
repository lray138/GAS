<?php 

use function lray138\GAS\Arr\toUl;

it('converts a simple array to an unordered list', function () {
    $array = ['Item 1', 'Item 2', 'Item 3'];
    $result = toUl($array);
    expect($result)->toBe('<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>');
});

it('includes attributes in the <ul> tag', function () {
    $array = ['Item A', 'Item B'];
    $attributes = ['class' => 'list', 'id' => 'items'];
    $result = toUl($array, $attributes);
    expect($result)->toBe('<ul class="list" id="items"><li>Item A</li><li>Item B</li></ul>');
});

it('handles an empty array', function () {
    $array = [];
    $result = toUl($array);
    expect($result)->toBe('<ul></ul>');
});

// come back to this, interesting
// it('escapes HTML characters in array items', function () {
//     $array = ['Item <b>1</b>', '<script>alert("XSS")</script>'];
//     $result = toUl($array);
//     expect($result)->toBe('<ul><li>Item &lt;b&gt;1&lt;/b&gt;</li><li>&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;</li></ul>');
// });