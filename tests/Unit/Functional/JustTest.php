<?php 

use function lray138\GAS\Functional\Just\unit;
use const lray138\GAS\Functional\Just\unit;
//use function FunctionalPHP\FantasyLand\bind;
use FunctionalPHP\FantasyLand\Monad;
use lray138\GAS\Types\Maybe\Just;

// reversing argument order to go with the book's order
function bind(Monad $value, callable $function) {
    return $value->bind($function);
}

it('passes monad axiom 1 from Pro Functional PHP (Apress)', function () {
    $i = "arbitrary";
    $func = "strtoupper";
    $result = bind(unit($i), $func) == $func($i);
    expect($result)->toBeTrue();
});

// I actually was expecting this to fail and then when it passed I realized 
// what it was doing ... obviously... 
it('passes monad axiom 2 from Pro Functional PHP (Apress)', function () {
    $monad = Just::of("example");
    $result = bind($monad, unit) == $monad;
    expect($result)->toBeTrue();
});

// this is what got be here because chatGPT fed me an incorrect test 
// needed to extract a value in the function which reminded me of this third one
// it's the chain test in "Type" 

it('passes monad axion 3', function() {
    $x = "example";
    $monad = Just::of($x);
    $f1 = fn($value) => Just::of(strtoupper($value));
    $f2 = fn($value) => str_replace("E", "", $value);

    $left = bind(bind($monad, $f1), $f2);
    $right = bind($monad, function($x) use ($f1, $f2) { 
        return bind($f1($x), $f2);
    });

    $expected = "XAMPL";

    expect($left == $expected)->toBeTrue();
    expect($right == $expected)->toBeTrue();

    $result = bind(bind($monad, $f1), $f2) == bind ($monad, function($x) use ($f1, $f2) { 
        return bind($f1($x), $f2);
    });

    expect($result)->toBeTrue();
});
