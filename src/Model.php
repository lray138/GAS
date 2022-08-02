<?php

namespace lray138\GAS\Model;

/* I see this is using the SQL builder thing I don't really like anymore */

use lray138\GAS\{
	Functional as FP,
	SQL,
	PDO,
	Types as T
};

use function lray138\GAS\dump;

function create() {
	//$model = function($db, $table) {
	$model = function($table, $db) {

		$model["db"] = $db;

		// $model["selectWhere"] = function($columns, $where, $options = []) use ($db, $table) {
		// 	$query = SQL\selectWhere($table, $columns, $where, $options);
		// 	$stmt = $db->prepare($query["sql"]);
		// 	$stmt->execute($query["values"]);
		// 	return $stmt->fetchAll();
		// };

		$model["selectWhere"] = function($columns, $where, $options = []) use ($db, $table) {
			$sql = "SELECT " . SQL\handleColumns($columns) . " FROM " . $table . " WHERE " . $where;
			$stmt = $db->prepare($sql);
			$stmt->execute([]);
			return PDO\prepareExecFetchAll($sql, $db, $options);
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

		$model["all"] = function(T\ArrType $options = null) use ($model, $table) {
			$response = PDO\queryFetchAll(SQL\select($table, $options), $model["db"]);
			return $response;
			//return $model["db"]->queryFetchAll("SELECT * FROM $table");
		};

		return T\Arr($model);
	};

	return call_user_func_array(FP\curry2($model), func_get_args());
}

const create = __NAMESPACE__ . '\create';