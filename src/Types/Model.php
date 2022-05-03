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
		$sql = "SELECT " . SQL\columns($options) . " FROM " . $this->table . SQL\orderBy($options);
		return PDO\prepareExecFetchAll($sql, $this->db);
	}

	public function oneWhere($column, $operand, $value, $options = null) {
		$sql = "SELECT " . SQL\columns($options) . " FROM " . $this->table . " WHERE " . $column . " " . $operand . " ?";

		return PDO\prepareExecFetch($sql, $this->db, [$value]);

	}

	public function __construct($table, $db) {
		$this->table = $table;
		$this->db = $db;
	}

}