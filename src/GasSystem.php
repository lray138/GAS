<?php 

namespace lray138\GAS\GasSystem;

use lray138\GAS\Types\Maybe;

use lray138\GAS\{
	Str, 
	Arr, 
	Functional as FP, 
	Math, 
	HTML, 
	SQL,
	Filesystem as FS,
	Model,
	PDO
};

use function lray138\GAS\IO\dump;

use lray138\GAS\Types\{Arr as ArrType, Str as StrType, None};

function slugToModelName(StrType $slug): StrType {
	return slugToPascalCase($slug)->append("Model");
}

function slugToControllerName(StrType $slug): StrType {
	return slugToPascalCase($slug)->append("Controller");
}

function slugToPascalCase(StrType $slug): StrType {
	// return FP\compose(
	// 		Arr\join(""),
	// 		Arr\map(FP\unary("ucfirst")),
	// 		Str\explode("-")
	// 	)($slug);
	return $slug->explode("-")
				->map(FP\unary("ucfirst"))
				->join("");
}

function loadSite(StrType $dir, StrType $name) {
	if(is_dir($dir->extract() . "/" . $name->extract())) {
		return Classes\Site::create([
			"dir" => $dir->rtrim("/")->append("/", $name),
			"name" => $name
		]);
	}
}

function getSites() {
	return FS\getDirs(dirname(dirname(__DIR__)) . "/sites");
}

function getPathSegments($path) {
	return array_filter(explode("/", $path));
}

function request($data) {
	if(is_null($data["path"])) {

	} else {
		$bits = explode("/", $data["path"]);
		$module_dir = Arr\join("/", [$data["doc_root"], "sites/main/modules", $bits[0]]);
		if(FS\dirExists($module_dir)) {
			$data["path"] = implode("/", Arr\tail($bits));
			$data["current_slug"] = $bits[0];
			return (include $module_dir . "/controllers/Main.php")($data);
			//return (include $module_dir . "/" . ucfirst($bits[0]) . "Controller.php")($data);
		}
	}
}

/*

*/
function main() {
	$main = function($controller, $data) {
		// if($controller["check_access"])

		$callable = hasSegments($data["path"])
					? "handleSegments"
					: "handleIndex";

		$loader = FP\curry2(function($dir, $name) {
			$name = !Str\endsWith(".php")($name) ? Str\append(".php")($name) : $name;
			$dir = !Str\endsWith("/")($dir) ? Str\concat($dir, "/") : $dir;
			return include $dir . $name;
		});

		if(array_key_exists("modules", $data)) {
			$data["modules"][] = [
				"name" => $data["current_slug"],
				"path" => $data["modules"][count($data["modules"])-1]["path"] . "/" . $data["current_slug"],
				"url" => $data["base_url"] . $data["modules"][count($data["modules"])-1]["path"] . "/" . $data["current_slug"],
				"dir" => $controller["module"]["dir"]
			];
		} else {
			$data["modules"][] = [
				"name" => Str\afterLast("/", $controller["module"]["path"]),
				"path" => $controller["module"]["path"],
				"url" => $controller["base_url"] . "/" . $data["current_slug"],
				"dir" => $controller["module"]["dir"]
			];

			//$data["base_url"] = $controller["base_url"];
			$data["views_dir"] = $controller["module"]["dir"] . "/views";
			$data["partials_dir"] = $controller["module"]["dir"] . "/partials";
		}

		$data["loadPartial"] = $loader($data["partials_dir"]);
		$data["loadView"] = $loader($data["views_dir"]);
		$data["loaders"]["partials"] = $loader($data["partials_dir"]);
		$data["loaders"]["views"] = $loader($data["views_dir"]);

		$data["current_module"] = &$data["modules"][Math\sub1(count($data["modules"]))];
		
		//if(FP\fileExists($data["current_module"] . "/"))

		if(isset($controller["module"]["table"])) {
			$data["current_module"]["table"] = $controller["module"]["table"];
		}

		if(isset($controller["database"])) {
			//$data["db"]->use($controller["database"]);
			$data["db"] = PDO\useDatabase($controller["database"], $data["db"]);
		}

		if(file_exists($data["modules"][0]["dir"] . "/models/" . $data["current_module"]["name"] . ".php")) {
			$data["model"] = loadModel($data["modules"][0]["dir"] . "/models", $data["current_module"]["name"])($data["db"]);
		} else {
			$data["model"] = model($data["db"], $data["current_module"]["name"]);
		}

		unset($controller["module"]);
		$out = array_merge($controller, $data);
		return $controller[$callable]($out);
	};

	return call_user_func_array(FP\curry2($main), func_get_args());
}

const main = __NAMESPACE__ . '\main';

function hasSegments(string $path) {
	return count(array_filter(explode("/", $path))) > 0;
}

function getFirstSegment(string $path) {
	return array_filter(explode("/", $path))[0];
}

function includeTemplate($filename, array $page) {
	include $filename;
}

function htmlResponse($data) {
	return [
		"type" => "html",
		"data" => $data
	];
}

function invokePartial() {
	return call_user_func_array(FP\curry2(function($data, $value) {
		return $value instanceof \Closure ? $value($data) : $value;
	}), func_get_args());
}

function updateTemplate($template, $node, $data_key, $content) {
	$node_path = explode("/", $node);

	// root case
	if($node === "html") {
		$template[$node][$data_key] = array_merge($content, $template[$node][$data_key]);
		return $template;
	}

	foreach($template["html"]["nodes"] as $key => $node) {
		if($node["name"] === Arr\head($node_path)) {
			$template["html"]["nodes"][$key][$data_key][] = $content;
			break;
		}
	}
	return $template;
}


function renderPage($data) {

	if(isset($data["template"])) {

		$template = $data["template"];
		asort($template);

		$map = function($x) use (&$map, $data) {
			if(is_array($x)) {

				if(array_key_exists("nodes", $x)) {
					
					$attributes = isset($x["attributes"]) ? $x["attributes"] : [];
					$affix_in = isset($x["affix_in"]) ? $x["affix_in"] : [];
					$affix_out = isset($x["affix_out"]) ? join($x["affix_out"]) : "";
					$prefix_out = isset($x["prefix_out"]) ? join($x["prefix_out"]) : "";
					$prefix_in = isset($x["prefix_in"]) ? $x["prefix_in"] : [];
					
					$nodes = array_merge($prefix_in, Arr\map($map, $x["nodes"]), $affix_in);

					return join([
						$prefix_out, 
						call_user_func_array('lray138\GAS\HTML\\' . $x["name"], [$nodes, $attributes]),
						$affix_out
					]);	
				} else if(isset($x["name"])) {

					$values = in_array($x["name"], HTML\getVoidElements()) 
								? Arr\pluckOrNull(["attr"])($x)
								: Arr\pluckOrNull(["content", "attr"])($x);

					return call_user_func_array(
							'lray138\GAS\HTML\\' . $x["name"], 
							$values
					);
				} 

				return join(Arr\map(invokePartial($data), $x));
			} 

			return $x;
		};

		foreach($template["html"]["nodes"] as $key => $node) {
			if($node["name"] === "body") {
				if(isset($data["body_class"])) {
					$template["html"]["nodes"][$key]["attributes"]["class"] = $data["body_class"];
				}
				if(isset($data["prefix_view"])) {
					$template["html"]["nodes"][$key]["nodes"][] = $data["prefix_view"];
				} 
				if(isset($data["view"])){
					$template["html"]["nodes"][$key]["nodes"][] = $data["view"];
				}
				if(isset($data["affix_view"])) {
					$template["html"]["nodes"][$key]["nodes"][] = $data["affix_view"];
				}
				break;
			}
		}

		$findNode = function($path, $values) {
			return Arr\first(function($x) {
				return $x["name"] === "head";
			})($values["nodes"]);
		};

		$template["html"]["nodes"][0]["nodes"][] = [
			"name" => "title",
			"content" => isset($data["title"]) ? $data["title"] : "Site Title"
		];

		$mapped = Arr\map($map, $template["html"]["nodes"]);

		$doctype = isset($template["doctype"]) ? "<!DOCTYPE html>" : "";
		$attributes = isset($template["html"]["attributes"]) ? $template["html"]["attributes"] : [];


		return $doctype . HTML\html(join($mapped), $attributes);
	}

}

function loadModel() {
	$loadModel = function($module_dir, $name, $db) {
		return (include $module_dir . "/" . $name . ".php")($db, $name);
	};

	return call_user_func_array(FP\curry3($loadModel), func_get_args());
}

function model() {
	return call_user_func_array(Model\create, func_get_args());
}

const model = __NAMESPACE__ . '\model';

// // main function
// function main(ArrType $data) {
// 	$segments = $data->path->explode("/")->filter();

// 	// if no segments, load home
// 	if($segments->isEmpty()) {
// 		$site = loadSite($data->doc_root->append("/sites/"), $data->main_site);
// 		$data = $data->set("site", $site)
// 					 ->set("module", $site->loadModule(StrType::of("home")));
// 	} elseif($data->multi_site) {

// 		// if multi site, check if first segment is a site
// 		if(is_dir($data->doc_root->append("/sites/", $segments->first())->extract())) {
// 			// load site
// 			echo "Load Site";
// 		// otherwise load the main site
// 		} else {
// 			$site = loadSite($data->doc_root->append("/sites/"), $data->main_site);
// 			$data = $data->set("site", $site);
// 		}

// 		$module = $site->loadModule($segments->first());
// 		if($module) {
// 			$data = $data->set("module", $module)
// 						 ->set("path", $segments->tail()->implode("/"));

// 		} elseif(is_dir($data->doc_root->append("/modules/", $segments->first()))) {
// 			$data = $data->set("module", loadModule($data->append("/modules/", $segments->first())))
// 						 ->set("path", $segments->tail()->implode("/"));

// 		} else {
// 			$data = $data->set("module", $site->loadModule("home"));
// 		}

// 	}

// 	return request($data);
// }


// function request(ArrType $data) {
// 	$response = "";
	
// 	if(!$data->path->isEmpty()) {
// 		$first_segment = $data->path->explode("/")->first();
// 		$module = $data->module->loadModule($first_segment)->extract();
// 		if($module) {
// 			$path = $data->path->explode("/")->tail()->implode("/");
// 			$path = $path->isEmpty()
// 						? None::of()
// 						: $path;
// 			return request($data->set("module", $module)
// 				 		        ->set("path", $path));
// 		}
// 	} 

// 	$first_segment = $data->path->explode("/")->first()->extract();

// 	// try method
// 	if(!$data->module->getController()->extract()) {
// 		$controller = $data->module->initController()->getController()->extract();
// 	}

// 	if(!$controller) {
// 		die("problem loading controller");	 
// 	} 

// 	$controller->attachDbHandler($data->db_handler);
// 	$method = "main";

// 	if($first_segment && method_exists($controller, $first_segment)) {
// 		$method = $first_segment;
// 		$data = $data->set("path", $data->path->explode("/")->tail()->extract());
// 	} 

// 	return handleResponse(array_merge($data->extract(), call_user_func_array([$controller, $method], [$data])));
// }


// function handleResponse($data) {

// 	// we have a response

// 	// load the template
// 	$view = Str\startsWith("/", $data["view"]) ? $view : $data["module"]->dir . "/views/" . $data["view"];
// 	$view = $view . ".php";

// 	unset($data["view"]);

// 	$data["title"] = "test";

// 	$view_func = function($data = null) use ($view) {
// 		extract($data);
// 		include $view;
// 	};

// 	$template_type = "standard";
// 	$template = "main";

// 	if($template_type === "standard") {
// 		$data["site"]->loadTemplate($template, $view_func, $data);
// 		return Maybe::of([]);
// 	} else {
// 		return Maybe::of([]);
// 	}

// }
