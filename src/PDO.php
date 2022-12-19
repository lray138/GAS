<?php 
namespace lray138\GAS\PDO;

/* at one point I started redesigning this to be more
"functional" in that you would start with a PDO object
in a container (i.e. Monad) and then map other operations
in which case you would need the PDO object as the 2nd
parameter.  This blew up existing code and also was, perhaps,
not so intuative. Also, splitting a version that doesn't
return Monadic types with one that does */

use lray138\GAS\{
	Functional as FP
	, Arr
	, Types as T
	, Types\Either
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

	$dsn = "mysql:host=" . $pluck(["host", "hostname"]) . ";charset=" . $pluck('charset') . ";";
	$dsn .= "dbname=" . $pluck(["database", "db", "dbname", "db_name"]);

	if(is_null($options)) {
		$options = getDefaultOptions();
	}

	//return FP\tryCatch(fn() => );
	try {
		return new \PDO($dsn, $pluck(["username", "user"]), $pluck(["password", "pass"]), $options);
	} catch (\Exception $e) {
		die($e);
	}
	
}

function connect(array $creds, $options = null) {
	return create($creds, $options);
}

function init($creds, $options = null) {
	$pdo = create($creds, $options);

	return [
		"pdo" => $pdo 
		, "fetch" => fetch($pdo)
		, "fetchAll" => fetchAll($pdo)
		, "qFetch" => qFetch($pdo)
		, "qFetchAll" => qFetchAll($pdo)
		, "query" => query($pdo)
		, "prepare" => prepare($pdo)
		, "insert" => insert($pdo)
	];
}

function useDatabase($db, $database_name) {
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

// function fetch($stmt) {
// 	return T\Arr($stmt->fetch());
// }

const fetch = __NAMESPACE__ . '\fetch';

// // you could add options here... ?
// function fetchAll($stmt, $options = null) {
// 	return T\Arr(Arr\map(T\Arr, $stmt->fetchAll()));
// }

const fetchAll = __NAMESPACE__ . '\fetchAll';

function prepare() {
	$f = function($pdo, $sql) {
		try {
			$stmt = $pdo->prepare($sql);
			return $stmt;
		} catch (\Exception $e) {
			//return T\Either::left($e);
		} catch (\Error $e) {
			//return T\Either::left($e);
		}
	};

	return FP\curry2($f)(...func_get_args());
}

const prepare = __NAMESPACE__ . '\prepare';

// I think the trade off for curryign here is making the 
// empty array always necessary, or you could always just 
// say curry2 if you don't want too
// the actual answer to this would be qFetchAll for query
// and fetchAll for the rest... 
function prepareExecFetchAll() {
	$f = function(\PDO $pdo, $sql, $values = [], $options = null) {
		if(!is_array($values)) {
			$values = [];
		}

		$mode = isset($options["mode"]) 
			? $options["mode"]
			: \PDO::FETCH_ASSOC;
			
		return prepareExec($pdo, $sql, $values)->fetchAll($mode);
	};

	return FP\curry3($f)(...func_get_args());
}

function fetchAll() {
	return prepareExecFetchAll(...func_get_args());
}

function fetch() {
	return prepareExecFetch(...func_get_args());
}

function prepareExec() {
	$f = function($pdo, $sql, $values = []) {
		if(!is_array($values)) {
			$values = [$values];
		}

		$stmt = $pdo->prepare($sql);
		$stmt->execute($values);
		return $stmt;
	};

	return FP\curry3($f)(...func_get_args());
}

const prepareExecFetchAll = __NAMESPACE__ . '\prepareExecFetchAll';

function prepareExecFetch() {
	$f = function($pdo, $sql, $values, $options = []) {
		if(!is_array($values)) {
			$values = [$values];
		}

		$mode = isset($options["mode"]) 
			? $options["mode"]
			: \PDO::FETCH_ASSOC;

		return prepareExec($pdo, $sql, $values)->fetch($mode);
	};

	return FP\curry3($f)(...func_get_args());
}

const prepareExecFetch = __NAMESPACE__ . '\prepareExecFetch';

// probalby should be "insert" ? or maybe there is a nahh.. dunno
// model??? I have that...
function prepareExecLastId() {
	$f = function($pdo, $sql, $values) {
		$stmt = prepareExec($pdo, $sql, $values);
		return $pdo->lastInsertId();
	};
	return FP\curry3($f)(...func_get_args());
}

function insert() {
	return prepareExecLastId(...func_get_args());
}

const prepareExecLastId = __NAMESPACE__ . '\prepareExecLastId';

function queryFetchAll() {
	$f = function($pdo, $sql) {
		return query($pdo, $sql)->fetchAll();
	};
	return FP\curry2($f)(...func_get_args());
}

const queryExecLastId = __NAMESPACE__ . '\queryExecLastId';

function queryFetch() {
	$f = function($pdo, $sql) {
		return query($pdo, $sql)->fetch();
	};
	return FP\curry2($f)(...func_get_args());
}

function qFetch() {
	return queryFetch(...func_get_args());
}

function qFetchAll() {
	return queryFetchAll(...func_get_args());
}

function query() {
	$f = function($pdo, $sql) {
		return $pdo->query($sql);
	};
	return FP\curry2($f)(...func_get_args());
}