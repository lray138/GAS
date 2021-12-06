<?php 
namespace lray138\GAS\SQL;

use lray138\GAS\Functions\{
	Functional as FP,
	Arr,
	Str,
	IO
};

function useKeys() {
	$addKeys = function($keys, $values) {

	};

	return call_user_func_array(FP\curry2($addKeys), func_get_args());
}

// not a great candidate for currying... 
function select() {
	$select = function($table, $columns, $conditions) {
		$sql = [
			"SELECT",
		    handleColumns($columns),
		    "FROM",
		    $table,
		    "WHERE",
		    handleConditions($prepare, $conditions)
		];

		return Arr\join(" ", $sql);
	};

	return call_user_func_array(FP\curry3($select), func_get_args());
}

const select = __NAMESPACE__ . '\select';

function selectWhere($table, $columns, $where, $conditions = [], $prepare = true) {
	//$conditions["where"] = $where;
	// structuring data so it can be mapped means not using associative for key, but needs a key in
	if(!is_array($conditions)) { $conditions = []; }

	$conditions[] = [
		"type" => "WHERE",
		"text" => $where
	];

	$conditions = handleConditions($prepare, $conditions);
	$sql = Arr\join(" ")([
			"SELECT",
			handleColumns($columns),
			"FROM",
			$table,
			$conditions["sql"]
	]);

	//Arr\find()
	return [
		"sql" => $sql,
		"values" => $conditions["values"]
	];
}

function insert() {
	$insert = function($table, $data) {
		$wrap = Str\wrap("(", ")");
		$stmt = [
			"INSERT INTO $table",
			$wrap(handleColumns($data)),
			"VALUES",
			$wrap(getPlaceholders($data))
		];

		return Arr\join(" ", $stmt);
	};

	return call_user_func_array(FP\curry2($insert), func_get_args());
}

function getPlaceholders(array $data) {
	return Arr\implode(", ", Arr\map(function($x) {
		return "?";
	}, $data));
}

function update($table, $data) {
	$id = $data["id"];
	unset($data["id"]);

	return [
		"sql" => Arr\join(" ")([
					"UPDATE $table SET",
				  	Arr\join(", ")(Arr\joinKeyVal(" = ", Arr\map(function($x) { return "?"; })($data))),
				  	"WHERE id = $id"
		]),
		"values" => array_values($data)
	];
}

function handleColumns($input) {

	$handleData = function(array $data) {
		return Arr\isAssoc($data)
				? array_keys($data)
				: $data;
	};

	return !is_array($input) 
			? $input 
			: Arr\implode(", ", $handleData($input));
}

function handleConditions($prepare, $input) {
	if(!is_array($input)) {
		return $input;
	} 

	$values = [];
	$sql = FP\compose(
		Arr\join(" "),
		Arr\map(function($x) use ($prepare, &$values) {
			// with the string it is harder...
			// otherwise it would be array indexes for the replacement.
			$text = is_string($x["text"]) ? explode(" ", $x["text"]) : $x["text"];
			if($prepare) { 
				$values[] = (function($x) {
					return FP\compose(
						Str\replace('"', ""),
						Str\replace("'", "")
					)($x);
				})(Arr\join(" ")(array_slice($text, 2)));
				$text = array_slice($text, 0, 2);
				$text[2] = "?";
			}
			$out = $x["type"] . " " . Arr\join(" ")($text);
			return $out;
		})
	)($input);

	return [
		"sql" => $sql,
		"values" => $values
	];

	// var_dump(FP\composeArr\join(Arr\map(function($x) {
	// 	return $x["type"] . " " . $x["text"];
	// })($input));

	/* 
	
	[
		[
			"something", "=", "something"
		],
		[
			"or",
			["somethign", "=", "something"]
		],
		[
			"and",
			[
				[
					
				]
			]
		]
	]
	
	*/

}