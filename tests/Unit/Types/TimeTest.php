<?php

use lray138\GAS\Types\Time;
use lray138\GAS\Types\Boolean as Boo;
use lray138\GAS\Types\Either\Left;

describe('Pointed', function () {
    
    it('constructs properly', function () {
        
        expect(Time::of("nowhere")
            ->exists()
            ->extract()
        )->toBe(false);

        expect(Time::of("2024-12-01")
            ->exists()
            ->extract()
        )->toBe(true);

    });

});

