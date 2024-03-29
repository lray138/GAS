<?php 

namespace lray138\GAS\Classes;

class Component {

	public static function of($path) {
		return new self($path);
	}

	public function __construct($path) {
		$this->path = $path;
	}

	public function __toString() {
		return "Component";
	}

}