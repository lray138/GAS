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

	public function all($options = null) {
		$options = is_array($options) ? T\Arr($options) : $options;

		$sql = is_null($options) 
			? SQL\select($this->table, T\Arr())
			: SQL\select($this->table, $options);
		return PDO\prepareExecFetchAll($this->db, $sql, []);
	}

	public function oneWhere($column, $operand, $value, $options = null) {
		$sql = "SELECT " . SQL\columns($options) . " FROM " . $this->table . " WHERE " . $column . " " . $operand . " ?";

		return PDO\prepareExecFetch($this->db, $sql, [$value]);
	}

	public function __construct($table, $db) {
		$this->table = $table;
		$this->db = $db;
	}

}