<?php 

use function lray138\GAS\Arr\filterUseKey;

function _filterKeys($key) {
    return strpos($key, 't') === 0;
}

it('it filters by keys', function() {
    $array = ["test" => 26, "whatever" => 2, "OK" => 1];
    $result = filterUseKey("_filterKeys", $array);

    expect($result)->toBe(["test" => 26]);
});