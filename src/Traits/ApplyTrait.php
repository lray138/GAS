<?php namespace lray138\GAS\Traits;

use FunctionalPHP\FantasyLand\Apply;

trait ApplyTrait { 
    // public function ap($that): Apply {
    //     return $that->map(function ($value) {
    //         return $this->extract()($value);
    //     });
    // }

    public function ap(Apply $f): Apply {
        //return $f->map($this->get());
        return new static($this->extract()($f->extract()));
    }
}