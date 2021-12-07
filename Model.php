<?php

namespace lray138\GAS\Model;

/* I see this is using the SQL builder thing I don't really like anymore */

use lray138\GAS\{
	Functional as FP,
	SQL,
	PDO
};

function create() {
	$model = function($db, $table) {
		$model["db"] = $db;

		// $model["selectWhere"] = function($columns, $where, $options = []) use ($db, $table) {
		// 	$query = SQL\selectWhere($table, $columns, $where, $options);
		// 	$stmt = $db->prepare($query["sql"]);
		// 	$stmt->execute($query["values"]);
		// 	return $stmt->fetchAll();
		// };


		$model["selectWhere"] = function($columns, $where, $options = []) use ($db, $table) {
			//$query = SQL\selectWhere($table, $columns, $where, $options);
			$sql = "SELECT " . $columns . " FROM " . $table . " WHERE " . $where;


			$stmt = $db->prepare($sql);
			$stmt->execute([]);
			return $stmt->fetchAll();
		};

		$model["where"] = function($where, $options = []) use ($model) {
			return $model["selectWhere"]("*", $where, $options);
		};

		$model["insert"] = function($data) use ($db, $table) {
			$sql = SQL\insert($table, $data);
			// leaving line for example of Functional vs. OO
			//$stmt = $db->prepareExec($sql, array_values($data));
			$stmt = PDO\prepareExecLastId($db, $sql, array_values($data));
		};
		
		$model["update"] = function($data) use ($db, $table) {
			$query = SQL\update($table, $data);
			$stmt = $db->prepare($query["sql"]);
			$stmt->execute($query["values"]);
			return $stmt->fetchAll();
		};

		$model["hasSlug"] = function($slug) use ($model) {
			$results = $model["selectWhere"](["*"], "slug = $slug");
			return count($results) === 1 ? $results[0] : null;
		};

		$model["all"] = function($options = []) use ($model, $table) {
			return $model["db"]->queryFetchAll("SELECT * FROM $table");
		};

		return $model;
	};

	return call_user_func_array(FP\curry2($model), func_get_args());
}

const create = __NAMESPACE__ . '\create';