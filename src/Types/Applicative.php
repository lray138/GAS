<?php 

// essentially you can map values or functions... 
namespace lray138\GAS\Types;

class Applicative extends Functor {

	public function apply($f) {
		// I suppose if you use the extract function
		// the variable can be whatever, but I would 
		// lean toward just doing $this->value
        return $f->map($this->extract());
    }

}