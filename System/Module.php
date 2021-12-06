<?php 

namespace lray138\GAS\System;

use function lray138\GAS\Filesystem\includeFileReturnObject;
use lray138\GAS\Types\{Arr, None, Maybe, Str};
use lray138\GAS\System\Model;
use lray138\GAS\Str as S;

class Module {

	public $dir;
	public $url;
	public $name;
	public $parent;
	public $controllers;

	public $data;

	public function loadController(Str $dir_name, Model $model = null) {
		$controller_name = \GAS\Functions\System\slugToControllerName($dir_name);
		$filename = $this->dir->append("/", $controller_name, ".php");
		return includeFileReturnObject($filename, $controller_name, [$model]);
	}

	public function loadModel(Str $dir_name) {
		$model_name = \GAS\Functions\System\slugToModelName($dir_name);
		$filename = $this->dir->append("/", $model_name, ".php");
		return includeFileReturnObject($filename, $model_name, [$dir_name]);
	}

	public function initController(Str $name = null) {
		if(is_null($name)) {
			$name = $this->name;
		}

		if(empty($name)) {
			return None::of("problem in model");
		}

		$model = $this->loadModel($name);
		$this->controllers = $this->controllers->set($name, $this->loadController($name, $model));
		return $this;
	}

	public static function create(Arr $data) {
		return new self($data);
	}

	public function hasModule(Str $name) {
		return is_dir($this->dir->append("/modules/", $name));
	}

	public function loadModule(Str $name) {
		if($this->hasModule($name)) {
			$self = new self(Arr::of([])
								->set("dir", $this->dir->append("/modules/", $name))
								->set("name", $name)
								->set("url", S\concatN(3, $this->url, "/", $name))
								->set("parent", $this));
			return Maybe::of($self);
		} else {
			return None::of();
		}
	}

	public function getController($name = null) {
		// this is where the auto plucking or whatever
		// would come in handy if it was null and we are returning
		// a Maybe or something, then it might be nested.
		$data = is_null($name) 
				? $this->controllers->get($this->name) 
				: $this->controllers->get($name);

		return Maybe::of($data);
	}

	public function __construct(Arr $data) {
		$this->controllers = Arr::of();
		$data->walk(function($value, $key) {
			$this->$key = $value;
		});
		// foreach($data as $key => $value) {
		// 	$this->$key = $value;
		// }
	}

}