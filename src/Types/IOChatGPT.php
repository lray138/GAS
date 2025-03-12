<?php 

namespace lray138\GAS\Types;

// curious to compare

class IOChatGPT {
    private $action;

    // Private constructor to create an IO instance with a callable action
    private function __construct(callable $action) {
        $this->action = $action;
    }

    /**
     * Lifts a function into an IO context.
     * Wraps a computation into an IO monad.
     */
    public static function of(callable $action): self {
        return new self($action);
    }

    /**
     * Map over the value inside the IO monad, without executing the side effect.
     * Transforms the value in a lazy manner.
     */
    public function map(callable $fn): self {
        return new self(function () use ($fn) {
            return $fn(($this->action)());
        });
    }

    /**
     * FlatMap (bind) over the value inside the IO monad.
     * Allows chaining of IO actions (useful for side-effecting operations).
     */
    public function bind(callable $fn): self {
        return new self(function () use ($fn) {
            return $fn(($this->action)())->run();
        });
    }

    /**
     * Executes the IO action and returns the result.
     * This triggers the side effects (e.g., file write).
     */
    public function run() {
        return ($this->action)();
    }

    /**
     * Lifts a value into an IO context, without a function.
     * Useful for directly injecting data into IO.
     */
    public static function lift($value): self {
        return new self(fn() => $value);
    }
}
