<?php 

namespace lray138\GAS\PDO;

use lray138\GAS\{
	Functional as FP,
	Arr
};

use function lray138\GAS\IO\dump;

function getDefaultOptions() {
	return [
		    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
		    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
		    \PDO::ATTR_EMULATE_PREPARES   => false,
	];
}

function getDefaultCharset() {
	return "utf8";
}

function create(array $creds, $options = null) {
	if(!isset($creds["charset"])) {
		$creds["charset"] = getDefaultCharset();
	}

	$pluck = FP\flipCurry2(Arr\pluck)($creds);

	$dsn = "mysql:host=" . $pluck("host") . ";charset=" . $pluck('charset') . ";";

	if(isset($creds["database"])) {
		$dsn .= "dbname=" . $pluck("database");
	}

	if(is_null($options)) {
		$options = getDefaultOptions();
	}
	
	try {
	     return new \PDO($dsn, $pluck("username"), $pluck("password"), $options);
	} catch (\PDOException $e) {
	     throw new \PDOException($e->getMessage(), (int) $e->getCode());
	}
}

function useDatabase($db, $database) {
	$db->exec("use " . $database);
	return $db;
}

function execStmt() {
	$f = function($stmt, $values) {
		// be kind
		if(!is_array($values)) {
			$values = [$values];
		}
		$stmt->execute($values);
		return $stmt;
	};

	return FP\curry2($f)(...func_get_args());
}

const execStmt = __NAMESPACE__ . '\execStmt';

function fetch($stmt) {
	return $stmt->fetch();
}

const fetch = __NAMESPACE__ . '\fetch';

function fetchAll($stmt) {
	return $stmt->fetchAll();
}

const fetchAll = __NAMESPACE__ . '\fetchAll';

function prepare() {
	$f = function($pdo, $stmt) {
		$stmt = $pdo->prepare($stmt);
		return $stmt;
	};

	return FP\curry2($f)(...func_get_args());
}

const prepare = __NAMESPACE__ . '\prepare';

function prepareExecFetchAll($pdo, $stmt, $values = []) {
	return FP\compose(
		fetchAll,
		FP\flipCurry2(execStmt)($values),
		prepare($pdo)
	)($stmt);
}

const prepareExecFetchAll = __NAMESPACE__ . '\prepareExecFetchAll';

function prepareExecFetch($pdo, $stmt, $values = []) {
	return FP\compose(
		fetch,
		FP\flipCurry2(execStmt)($values),
		prepare($pdo)
	)($stmt);
}

const prepareExecFetch = __NAMESPACE__ . '\prepareExecFetch';

// probalby should be "insert" ? or maybe there is a nahh.. dunno
// model??? I have that...
function prepareExecLastId($pdo, $sql, $values) {
	return FP\compose(
		function($x) use ($pdo) {
			return $pdo->lastInsertId();
		},
		FP\flipCurry2(execStmt)($values),
		prepare($pdo)
	)($sql);
}

const prepareExecLastId = __NAMESPACE__ . '\prepareExecLastId';

function queryFetchAll($pdo, $sql, $data = []) {
	return prepareExecFetchAll($pdo, $sql, $data);
}

const queryExecLastId = __NAMESPACE__ . '\queryExecLastId';