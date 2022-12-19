<?php

namespace lray138\GAS\Types;

/* I see this is using the SQL builder thing I don't really like anymore */

use lray138\GAS\{
	Functional as FP,
	SQL,
	Arr,
	PDO,
	Types as T
	, Str
};

use function lray138\GAS\dump;

class Model {

	private $table;
	private $db;
	private $default_mode = \PDO::FETCH_ASSOC;

	public function all($options = null) {

		// if($options instanceof \lray138\GAS\Types\ArrType) {
		// 	$options = $options->extract();
		// }

		$options = is_array($options) ? T\Arr($options) : $options;

		// $sql = is_null($options) 
		// 	? SQL\select($this->table, [])
		// 	: SQL\select($this->table, $options);

		$sql = "SELECT * FROM " . strtolower($this->getTableName());

		// $mode = count($options->pick("mode")->extract()) > 0
		// 	? $options->pick("mode")->extract()
		// 	: \PDO::FETCH_ASSOC;

		$mode = \PDO::FETCH_ASSOC;

		return PDO\prepareExecFetchAll($this->db, $sql, [], ["mode" => \PDO::FETCH_OBJ]);
	}

	public function getTableName() {
		return $this->table;
	}

	public function getDefaultMode() {

	}

	public function getDbConnection() {
		return $this->db;
	}

	public function oneWhere($column, $operand, $value, $options = null) {
		$sql = "SELECT " . SQL\columns($options) . " FROM " . $this->table . " WHERE " . $column . " " . $operand . " ?";

		return PDO\prepareExecFetch($this->db, $sql, [$value]);
	}

	public function __call($method, $args) {
		if(function_exists("lray138\GAS\PDO\\" .$method)) {

			return call_user_func_array("lray138\GAS\PDO\\" . $method, 
				array_merge([$this->getDbConnection(), ...$args])
			);
		} 
	}

	public function __construct($table, $db) {
		$this->table = $table;
		$this->db = $db;
	}

}