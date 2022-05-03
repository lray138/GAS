<?php 

namespace lray138\GAS\PDO;

use lray138\GAS\{
	Functional as FP
	, Arr
	, Types as T
};

use function lray138\GAS\IO\dump;
use function lray138\GAS\Functional\flip as _;

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

// this may be dumb but... 
// a, b, c, d, e
// where a can be either array of creds, or a server,
// b is either options or username
// c is always password (if present)
// d is always database (if present)
// e is always options (if present)
// then you could create either way you want
// if you wanted to curry apply later
function create(array $creds, $options = null) {
	if(!isset($creds["charset"])) {
		$creds["charset"] = getDefaultCharset();
	}

	$pluck = FP\flip(Arr\pluck)($creds);

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
	   	//throw new \PDOException($e->getMessage(), (int) $e->getCode());
		return T\Nothing();
	}
}


function useDatabase($database_name, $db) {
	$db->exec("use " . FP\extract($database_name));
	return $db;
}


// this is a case where 
// we need to examine well... hermm...
// we need $values first in the Functor context
function execStmt() {
	$f = function($values, $stmt) {
		// be kind
		if(!is_array($values)) {
			$values = [$values];
		}
		try {
			$stmt->execute($values);
			return T\Either::right($stmt);
		} catch (\Exception $e) {
			return T\Either::left($e);
		} catch (\Error $e) {
			return T\Either::left($e);
		}
		
	};

	return FP\curry2($f)(...func_get_args());
}

const execStmt = __NAMESPACE__ . '\execStmt';

function fetch($stmt) {
	return T\Arr($stmt->fetch());
}

const fetch = __NAMESPACE__ . '\fetch';

// you could add options here... ?
function fetchAll($stmt, $options = null) {
	return T\Arr(Arr\map(T\Arr, $stmt->fetchAll()));
}

const fetchAll = __NAMESPACE__ . '\fetchAll';

function prepare() {
	$f = function($sql, $pdo) {
		try {
			$stmt = $pdo->prepare($sql);
			return T\Either::right($stmt);
		} catch (\Exception $e) {
			return T\Either::left($e);
		} catch (\Error $e) {
			return T\Either::left($e);
		}
	};

	return FP\curry2($f)(...func_get_args());
}

const prepare = __NAMESPACE__ . '\prepare';

// I think the trade off for curryign here is making the 
// empty array always necessary, or you could always just 
// say curry2 if you don't want too
function prepareExecFetchAll($sql, $pdo, $values = []) {
	// old way
	// return FP\compose(
	// 	fetchAll,
	// 	FP\flip(execStmt)($values),
	// 	prepare($pdo)
	// )($stmt);

	// really you'd want to do // it sort of doesn't matter
	// anyway

	return T\Maybe::of($pdo)
		->chain(prepare($sql))
		->chain(execStmt($values))
		->either(function($x) {
			return T\Either::left($x);
		}, fetchAll)
		;
}

const prepareExecFetchAll = __NAMESPACE__ . '\prepareExecFetchAll';

function prepareExecFetch($sql, $pdo, $values = []) {
	// return FP\compose(
	// 	fetch,
	// 	FP\flip(execStmt)($values),
	// 	prepare($pdo)
	// )($stmt);

	return T\Maybe::of($pdo)
		->chain(prepare($sql))
		->chain(execStmt($values))
		->either(function($x) {
			return T\Either::left($x);
		}, fetch)
		;
}

const prepareExecFetch = __NAMESPACE__ . '\prepareExecFetch';

// probalby should be "insert" ? or maybe there is a nahh.. dunno
// model??? I have that...
function prepareExecLastId($pdo, $sql, $values) {
	return FP\compose(
		function($x) use ($pdo) {
			return $pdo->lastInsertId();
		},
		FP\flip(execStmt)($values),
		prepare($pdo)
	)($sql);
}

const prepareExecLastId = __NAMESPACE__ . '\prepareExecLastId';

function queryFetchAll($pdo, $sql, $data = []) {
	return prepareExecFetchAll($pdo, $sql, $data);
}

const queryExecLastId = __NAMESPACE__ . '\queryExecLastId';