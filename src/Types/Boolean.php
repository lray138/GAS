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
     */
    public function is() {
        return $this->value === true;
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

    /**
     * Check if the boolean is false (alias of isNot()).
     */
    public function isFalse() {
        return $this->isNot();
    }
}
