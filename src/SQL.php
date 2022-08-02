<?php 
namespace lray138\GAS\SQL;

use lray138\GAS\{
	Functional as FP,
	Arr,
	Str,
	IO,
	Types as T
};

use function lray138\GAS\dump;

function useKeys() {
	$addKeys = function($keys, $values) {

	};

	return call_user_func_array(FP\curry2($addKeys), func_get_args());
}

// not a great candidate for currying... 

// actually LOL'd because I tried to use this with table, options
// and agree with the above, whenever that was.
function select() {
	$select = function(string $table, T\ArrType $options = null) {
		// $sql = [
		// 	"SELECT",
		//     handleColumns($columns),
		//     "FROM",
		//     $table,
		//     "WHERE",
		//     handleConditions($prepare, $conditions)
		// ];

		$sql = "SELECT ". handleColumns($options) . " FROM $table";
		$sql = $sql . Str\padLeft(" a", handleConditions($options));
		$sql = $sql . Str\padLeft(" b", handleSorting($options));
		$sql = $sql . Str\padLeft(" c", handleLimits($options));

		// hmm this implementation is worse that whatever I was just doing that I'm
		// trying to replace... har...

		return $sql;
	};

	return call_user_func_array(FP\curry2($select), func_get_args());
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

	if(is_array($input)) {
		$input = T\Arr($input);
	}

	if(is_string($input) || $input->isString()) {
		return $input;
	}

	if(T\isNothing($input) || T\isNothing($input->columns->isNothing()) || $input->columns->isLeft()) {
		return "*";
	}



	return $input->columns->isString() 
		? $input->columns 
		: $input->columns->implode(", ");

	// assuming this is from trying to be "clever" 
	// and passing a key/val array rather than just passing
	// the keys by themselves?
	$handleData = function(array $data) {
		return Arr\isAssoc($data)
				? array_keys($data)
				: $data;
	};

	return "*";

	return !is_array($input) 
			? $input 
			: Arr\implode(", ", $handleData($input));
}

function handleConditions($options = null) {
	if(T\isNothing($options)) {
		return "";
	}

}

function handleConditionsOld($prepare, $input) {
	if(!is_array($input)) {
		return $input;
	} 

	// horrible documentation here... wonder wher I used this... 

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

function handleSorting($options) {

	if(T\isNothing($options)) {
		return "";
	}

	return $options->order_by->prepend("ORDER BY ")
		->append($options->order_direction->prepend(" "));

	// if($options->order_by->isString()) {
	// 	$out = "ORDER BY " . $options->order_by;

	// 	if($options)
	// }

	return "";
}

function handleLimits() {
	return "";
}


function columns($options) {
	return T\Maybe($options)
		->columns
		->if(FP\chain("is_array"), FP\bind(Arr\implode(", ")))
		->getOr("*");
}

function orderBy($options) {
	$options = T\Maybe($options);
	$order_by = $options
		->order_by
		->map(Str\prepend(" ORDER BY "))
		->map(Str\append(" " . strtoupper($options->order_direction->getOr(""))))
		->getOr("");
}
