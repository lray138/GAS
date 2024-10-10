<?php 

use function lray138\GAS\Str\wrap;

it('should wrap a value', function () {
    $str = "b";
    $result = wrap("a")("c")("b");
    expect($result)->toBe("abc");
});