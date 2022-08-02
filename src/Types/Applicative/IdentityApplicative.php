<?php namespace lray138\GAS\Types\Applicative;

class IdentityApplicative extends Applicative
{
    private $value;

    protected function __construct($value) {
        $this->value = $value;
    }

    public static function pure($value): Applicative {
        return new static($value);
    }

    public function apply(Applicative $f): Applicative {
        //return $f->map($this->get());
        return static::pure($this->extract()($f->extract()));
    }

    public function get() {
        return $this->value;
    }

    public function extract() {
        return $this->get();
    }

}