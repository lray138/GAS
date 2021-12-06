<?php 

namespace lray138\GAS\System;

class Controller {

	protected $model;

	public function update(\GAS\Types\Arr $data) {
		return "update";
	}

	public function attachDbHandler(\GAS\Database\DbHandler $handler) {
		// now this will be mutating???
		if($this->model) {
			$this->model->setHandler($handler);
		}
		
	}

	public function handleIndex(\GAS\Types\Arr $data) { }

	public function handleSegments(\GAS\Types\Arr $data) { }

	public function main(\GAS\Types\Arr $data) {

		if($data->path->length()->extract() > 0) {
			return $this->handleSegments($data);
		}

		return $this->handleIndex($data);
	}

	public function __construct($model) {
		$this->model = $model;
	}

}