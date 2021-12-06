<?php 

namespace lray138\GAS\System;

use lray138\GAS\Types\{Str, Arr};
use lray138\GAS\{Filesystem as FS, Str as S};

class Site {

	private $name;
	private $dir;
	private $url;
	private $template;
	private $template_type;
	
	public static function create($array) {
		return new self($array);
	}

	public function __construct($array) {
		

		foreach($array as $key => $val) {
			$this->$key = $val;
		}

		$path = $this->dir . "/config.json";
		$array = json_decode(FS\read($path), true);

		foreach($array as $key => $val) {
			$this->$key = $val;
		}

		$this->template = "main";
		$this->template_type = "standard";
	}

	public function loadModule(Str $name) {
		$dir = $this->dir . "/modules/" . $name;

		if(is_dir($dir)) {
			return Module::create(Arr::of([
				"dir" => $this->dir->append("/modules/", $name),
				"name" => $name,
				"url" => S\concatN(3, $this->url, "/", $name)
			]));
		}
	}

	public function loadView($name) {
		if(file_exists($name)) {
			return "view";
		}
	}

	public function loadTemplate($name, $view = null, $data = []) {
		$template_file = $this->dir . "/templates/" . $name . ".php";

		if(!file_exists($template_file)) {
			
		}

		if($this->template_type === "standard") {
			include $template_file;
		}
	}

	public function getTemplate() {
		return $this->template;
	}

}