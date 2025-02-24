<?php

namespace lray138\GAS\Types;

use FunctionalPHP\FantasyLand\{
    Monoid, 
    Semigroup
};

use lray138\GAS\Traits\ExtractValueTrait;

class Boolean extends Type implements Monoid {

    protected $value;
    protected $operation;

    public function __construct($value, $operation = "and") {
        $this->value = (bool) $value;
        $this->operation = $operation;
    }

    /**
     * Identity element for the monoid based on the operation.
     * For "and", the identity is true.
     * For "or", the identity is false.
     */
    public static function mempty($operation = null) {
        $operation = is_null($operation) ? "and" : $operation;
        $value = $operation === "and" ? true : false;
        return new self($value, $operation);
    }

    /**
     * Combine the current boolean with another boolean.
     * Implements the semigroup's associative operation.
     */
    public function concat(Semigroup $other): Boolean {
        if (!$other instanceof self) {
            throw new \InvalidArgumentException("Argument must be an instance of Boolean");
        }

        // Perform the combination based on the operation
        switch ($this->operation) {
            case "and":
                return new self($this->extract() && $other->extract(), "and");
            case "or":
                return new self($this->extract() || $other->extract(), "or");
            default:
                throw new \LogicException("Invalid operation: {$this->operation}");
        }
    }

    /**
     * Check if the boolean value is true.
     * this is stupid btw - Jan 6 2024
     */
    public function is() {
        return $this->value === true;
    }

    public function g() {
        return $this->extract();
    }

    /**
     * Check if the boolean value is false.
     */
    public function isNot() {
        return $this->value === false;
    }

    /**
     * Check if the boolean is true (alias of is()).
     */
    public function isTrue() {
        return $this->is();
    }

    public function ifTrue(callable $c) {
        return $this->extract()
            ? $c()
            : $this;
    }

    public function either(callable $false, callable $true) {
        $stored = $this->extract();
        return $this->extract()
            ? $true($stored)
            : $false($stored);
    }

    /**
     * Check if the boolean is false (alias of isNot()).
     */
    public function isFalse() {
        return $this->isNot();
    }

    // Jan 2 @ 15:04, I guess get wasn't in Type?
    public function get() {
        return $this->extract();
    }

    public function __toString() {
        return (string) $this->extract();
    }
    
}
