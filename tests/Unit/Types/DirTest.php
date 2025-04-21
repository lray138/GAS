<?php

use lray138\GAS\Types\Type;
use lray138\GAS\Types\Dir;

describe('Pointed', function () {
    
    it('constructs properly', function () {
        
        $dir = Dir::of("/Users/lray/site");

        expect($dir->exists()->get())->toBeTrue();

    });

    // You could add more tests related to Pointed functionality

});

