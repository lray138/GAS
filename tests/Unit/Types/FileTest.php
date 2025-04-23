<?php

use lray138\GAS\Types\Type;
use lray138\GAS\Types\File;

describe('Pointed', function () {
    
    it('constructs properly', function () {
        
        expect(File::of("nowhere")
            ->exists()
            ->extract()
        )->toBe(false);

        expect(File::of("/Users/lray/Sites")
            ->exists()
            ->extract()
        )->toBe(true);

    });

});
