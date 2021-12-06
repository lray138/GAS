<?php 

namespace lray138\GAS\System;

use lray138\GAS\Types\{Type, Str, Many};

class Model {

	private $table;
	private $handler;

	public function setHandler(\GAS\Database\DbHandler $handler) {
		$this->handler = $handler;
	}

	public function get(Type $key) {
		$column = is_int($key->value()) ? "id" : "slug";

		$stmt = "SELECT * FROM " . $this->table;
		$stmt .= " WHERE " . $column . " = ?";

		return \GAS\Types\Maybe::of($this->handler->prepareExecFetch($stmt, [$key->value()]));
	}

	public function all($options = []) {
		$stmt = "SELECT * FROM " . $this->table;
		$order = "";
		if(isset($options["order_by"])) { 
			$order .= " ORDER BY " . $options["order_by"]; 
		}

		if(!empty($order) && isset($options["order_direction"])) { $order .= " " . strtoupper($options["order_direction"]); }
		
		$columns = isset($options["select"]) ? $options["select"] : "*";

		$sql = "SELECT $columns FROM " . $this->table . $order;

		return Many::of($this->handler->prepareExecFetchAll($sql));
	}

	public function __construct(Str $table) {
		$this->table = $table;
	}

	public function getTable() {
		return $this->table;
	}

}