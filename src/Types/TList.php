<?php 

namespace lray138\GAS\Types;
use lray138\GAS\Types\Maybe;
use function lray138\GAS\IO\dump;

class TList {
    private $list;

    public function __construct($traversable) {
        if (!is_array($traversable) && !is_iterable($traversable)) {
            throw new InvalidArgumentException("Input must be an array or iterable");
        }

        if (is_array($traversable)) {
            $this->list = $traversable;
        } else {
            $this->list = iterator_to_array($traversable);
        }
    }

    public function filter($predicate) {
        $this->list = array_filter($this->list, $predicate);
        return $this;
    }

    public function map($callback) {
        $this->list = array_map($callback, $this->list);
        return $this;
    }

    public function reduce($callback, $initial = null) {
        $this->list = array_reduce($this->list, $callback, $initial);
        return $this;
    }

    public function getValue() {
        return $this->list;
    }

    public function extract() {
    	return $this->list;
    }

    public function transform(callable $operation) {
        // Apply the operation to the entire array
        $this->list = $operation($this->list);
        return $this;
    }

}