<?php

use lray138\GAS\Types\Type;
use lray138\GAS\Types\Dir;

describe('Pointed', function () {
    
    it('constructs properly', function () {
        
        expect(Dir::of("nowhere")
            ->exists()
            ->extract()
        )->toBe(false);

        expect(Dir::of("/Users/lray/Sites")
            ->exists()
            ->extract()
        )->toBe(true);

    });

    it('throws error when direct constructor is called', function () {
        new Dir("/some/path");
    })->throws(Error::class); // or TypeError, Exception, depending on how it's blocked

    

});

