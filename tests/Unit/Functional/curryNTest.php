<?php 

use function lray138\GAS\Functional\curryN;


// ok, I was looking at Idles and thought my curryN didn't do that
// not sure what example I was trying then.
it('curries N correctly', function () {
   
   	$func = curryN(3)(function($a, $b, $c, $d = "") {
   		return $a.$b.$c.$d;
   	});

    $result = $func("a", "b", "c", "d");
    expect($result)->toBe("abcd");

    $result = $func("a")("b")("c");
    expect($result)->toBe("abc");
});

