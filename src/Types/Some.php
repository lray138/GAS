<?php 

namespace lray138\GAS\Types;

class Some extends Maybe {
	
	public function __toString() {
		return $this->extract();
	}

}