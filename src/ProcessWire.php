<?php 

namespace lray138\GAS\ProcessWire;

use lray138\GAS\Str;
use lray138\GAS\Arr;
use lray138\GAS\Numbers;
use lray138\GAS\HTML;
use lray138\GAS\Functional as FP;

use function lray138\GAS\IO\dump;

function isNullPage($object) {
	return $object instanceof \ProcessWire\NullPage;
}

function getParent($page) {
	return $page->parent;
}

const getPageLink = __NAMESPACE__ . '\getPageLink';

// special options should be unset from what would otherwise be
// attributes
function getPageLink($page, $attributes = []) {
	$href = isset($attributes["base_url"]) ? $attributes["base_url"] . $page->url : $page->url;
	unset($attributes["base_url"]);
	return HTML\a($page->title, ["href" => $href]);
}

// I tried to call this with just a path and think if ... hmm
function pageExists($pages, $parent_path, $name = null) {
	if(is_null($name)) {
		$page = $pages->get($parent_path);
		return  $page instanceof \ProcessWire\NullPage ? false : $page;
	}

	$path = $parent_path === "/"
		? $parent_path . $name
		: $parent_path . "/" . $name;

	$page = $pages->get($path);

	return $page instanceof \ProcessWire\NullPage ? false : $page;
}

// so basically

// create page doesn't use the lookup,
// but create page new does
// and create page recursive uses the one with the lookup...

function createPage($pages, $data) {
	// the issue is, the page isn't created, we need the parent
	// so first things first, we need to pass the parent, get common child
	// if that's not there, we need go up a level, get sibligns, then children,
	// repeat.

	if(!isset($data["template"])) {
		$parent = $pages->get($data["parent_path"]);

		$data["template"] = getCommonSiblingChildTemplate($parent);

		if(is_null($data["template"])) {
			$data["template"] = getCommonRelativeChildTemplate($parent);
		}

		if(is_null($data["template"]) || empty($data["template"])) {
			die("Note template specified" . __FILE__ . ' line 71');
		}
	}

	// extra helpers
	// if parent_path isn't provided (i.e. we give id), lookup
	// if name isn't provided and title is use title for name
	// processwire will handle that
	if(!isset($data["parent_path"]) && isset($data["parent_id"])) {
		$data["parent_path"] = $pages->get($data["parent_id"])->path;
	} else if(!isset($data["parent_path"])) {
		return false;
	}

	// burned out, hate this logic

	if(!isset($data["name"]) && isset($data["title"])) {
		$data["name"] = $data["title"];
	} elseif(!isset($data["name"])) {
		return false;
	}

	$exists = pageExists($pages, $data["parent_path"], $data["name"]);	

	if($exists) {
		$page = $exists;
		//$page->of(true);
	} else {
		$page = $pages->add($data["template"], $data["parent_path"], $data["name"]);
	}

	return updatePage($page, $data, $pages);
}

function getCommonSiblingChildTemplate($parent) {
	$siblings = $parent->siblings(false);

	foreach($siblings as $sibling) {
		$children = $sibling->children();

		if(count($children) === 0) continue;

		return $children->first->template->name;
	}

	return null;
}

// would be cool to do a deeper dive on this
// but referencing https://stackoverflow.com/questions/659025/how-to-remove-non-alphanumeric-characters
function sanitizeName(string $str) {
	$str = str_replace(" ", "-", $str);
	return preg_replace('/[^a-z\d\-_]/i', '', $str);
}

function updatePage($page, $data, $pages = null) {
	// can't decide if I like "data" or "fields";
	if(!isset($data["fields"]) && isset($data["data"])) {
		$data["fields"] = $data["data"];
	}

	if(isset($data["title"])) {
    	$page->title = $data["title"];
    }

    // additional fields
    // foreach($data["fields"] as $key => $value) {
    //   	$page->$key = $value;
    // }

    $page->of(false);

    foreach($data["fields"] as $key=>$field ) {
  		if($key === "purchase_products") {
    		$page->save();
			$products = $field;

			// these are the products from the form
			foreach($products as $product) {
				$item = $page->purchase_products->getNewItem();

				foreach($product as $key2=>$prod) {
					$item->$key2 = $prod;
				}

				if(isset($product["purchase_unit_price"]) && !empty(trim($product["purchase_unit_price"]))) {
					$product_page = $pages->get($product["purchase_set_product_page"]);
					if(!$product_page->product_measured) {
						$product_page->product_measured = true;	
					}
					$product_page->product_measured_last_price_per = $product["purchase_unit_price"];
					$product_page->save();
				}

				$item->save();
				$page->purchase_products->add($item);
			}
			$page->save('purchase_products');
		} else {
			$page->$key = $field;
		}
	}

    $page->save();

    return $page;
}

const createPage = __NAMESPACE__ . '\createPage';

function createPageRecursive($pages, $data, $carry = []) {
	if($data["parent_path"] === "") {
		// via https://processwire.com/talk/topic/2160-createupdate-a-page-programmatically/
		// $home = $pages->get("/");
		// $home->of(false);
		// $home->name = $data["name"];
		// $home->title = $data["title"];
		// $home->save();
		return updatePage($pages->get("/"), $data, $pages);
	}

	$parent = $pages->get($data["parent_path"]);

	if(!isNullPage($parent)) {
		$page = createPage($pages, $data);

		if(count($carry) === 0) {
			return $page;
		}

		$data = array_shift($carry);
	} else {
		array_unshift($carry, $data);

		$parent_path = Str\beforeLast("/", $data["parent_path"]);
		
		if(empty($parent_path)){ 
			$parent_path = "/";
		}

		$data = [
			"parent_path" => $parent_path,
			"name" => Str\afterLast("/", $data["parent_path"])
		];
	}
		
	return createPageRecursive($pages, $data, $carry);
};


const createPageRecursive = __NAMESPACE__ . '\createPageRecursive';

// adding code to make sure each page type is the same???
function getCommonRelativeChildTemplate($page, $depth = 0) {

	if($depth == 0) {
		$children = Arr\filter(function($page) {
			return $page->hasChildren();
		}, $page->children->getArray());

		if(count($children) === 0) {
			return getCommonRelativeChildTemplate($page, Numbers\add(1, $depth));
		}

		$template_name = $children[0]->template->name;

		// if(is_null($template_name)) {
		// 	return getCommonRelativeChildTemplate($page, Math\add(1, $depth));
		// } 
	} else {

		$page_original = $page;
		$x = $depth;

		while($x > 0) {
			$page = $page->parent;
			$x--;
		}

		if(is_null($page) || isNullPage($page) || count($page->children()) === 0) {
			return null;
		}

		$page = $page->siblings(false)->first;
		
		$x = $depth;
		while($x > 0) {

			$children = Arr\filter(function($page) {
				return $page->hasChildren();
			}, $page->children->getArray());

			$page = $children[0];

			$x--;
		}
		
		if(is_null($page) || isNullPage($page) || count($page->children()) === 0) {
			return getCommonRelativeChildTemplate($page_original, Math\add(1, $depth));
		}

		$unique = getUniqueChildTemplates($page);
		arsort($unique);
		$template_name = array_keys($unique)[0];
	}

	return $template_name;
}

function getUniqueChildTemplates($page) {
	// so this is where that one guy says don't use monads in PHP? 
	// It would be cool to do something like ArrayMonad, right? and run stuff on it?
	$templates = [];
	foreach($page->children() as $p) {
 		$template_name = $p->template->name;
  		// if(!in_array($template_name, $templates)) {
    // 		$templates[] = $template_name;
  		// }
  		if(!array_key_exists($template_name, $templates)) {
  			$templates[$template_name] = 1;
  		} else {
  			$templates[$template_name] = $templates[$template_name] + 1;
  		}
	}

	return $templates;
}

function movePage($new_parent, $page) {


	die('here');
	$page->parent = $new_parent;
	$page->save();
}

const movePage = __NAMESPACE__ . '\movePage';