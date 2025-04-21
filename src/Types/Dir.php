<?php 

namespace lray138\GAS\Types;

use lray138\GAS\Types\Either;
use lray138\GAS\Types\ArrType as Arr;

use function lray138\GAS\dump;

use lray138\GAS\Types\Either\{Left, Right};
use \FunctionalPHP\FantasyLand\{Apply, Monad, Semigroup};
use lray138\GAS\Types\Comonad;
use function lray138\GAS\dump;

/**
 * An OO-looking implementation of Either in PHP.
 */
abstract class Resource implements Monad, Comonad, Semigroup {

    public static function of($path) {
        return is_dir($path) 
            ? new static($path)
            : Either::left($path . " is not a valid directory.");
    }

    public function __construct($path) {
        $this->value = $path;
    }

    public function path(): string {
        return $this->extract();
    }

}