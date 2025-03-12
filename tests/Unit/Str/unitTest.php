<?php 

use function lray138\GAS\Str\unit;

// waterfall tests

it('constructs using pointed', function () {

    expect(unit("Hello World!")->get())->toBe("Hello World!");
    expect(unit(1)->get())->toBe("1");

});

