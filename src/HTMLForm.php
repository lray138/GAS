<?php 
 
namespace lray138\GAS\HTMLForm;

use lray138\GAS\{
  Arr,
  HTML,
  Functional as FP
};

use function lray138\GAS\IO\dump;

function button($content, $attributes = []) {
	return element("button", $content, $attributes);
}

const button = __NAMESPACE__ . '\button';

function datalist($content, $attributes = []) {
	return element("datalist", $content, $attributes);
}

const datalist = __NAMESPACE__ . '\datalist';

function fieldset($content, $attributes = []) {
	return element("fieldset", $content, $attributes);
}

const fieldset = __NAMESPACE__ . '\fieldset';

function form($content, $attributes = []) {
	return element("form", $content, $attributes);
}

const form = __NAMESPACE__ . '\form';

function inputButton($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "inputButton"]));
}

const inputButton = __NAMESPACE__ . '\inputButton';

function checkbox($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "checkbox"]));
}

const checkbox = __NAMESPACE__ . '\checkbox';

function color($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "color"]));
}

const color = __NAMESPACE__ . '\color';

function date($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "date"]));
}

const date = __NAMESPACE__ . '\date';

function datetimeLocal($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "datetimeLocal"]));
}

const datetimeLocal = __NAMESPACE__ . '\datetimeLocal';

function datetime($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "datetime"]));
}

const datetime = __NAMESPACE__ . '\datetime';

function email($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "email"]));
}

const email = __NAMESPACE__ . '\email';

function file($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "file"]));
}

const file = __NAMESPACE__ . '\file';

function hidden($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "hidden"]));
}

const hidden = __NAMESPACE__ . '\hidden';

function image($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "image"]));
}

const image = __NAMESPACE__ . '\image';

function month($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "month"]));
}

const month = __NAMESPACE__ . '\month';

function number($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "number"]));
}

const number = __NAMESPACE__ . '\number';

function password($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "password"]));
}

const password = __NAMESPACE__ . '\password';

function radio($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "radio"]));
}

const radio = __NAMESPACE__ . '\radio';

function range($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "range"]));
}

const range = __NAMESPACE__ . '\range';

function reset($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "reset"]));
}

const reset = __NAMESPACE__ . '\reset';

function search($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "search"]));
}

const search = __NAMESPACE__ . '\search';

function submit($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "submit"]));
}

const submit = __NAMESPACE__ . '\submit';

function tel($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "tel"]));
}

const tel = __NAMESPACE__ . '\tel';

function telephone($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "telephone"]));
}

const telephone = __NAMESPACE__ . '\telephone';

function text($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "text"]));
}

const text = __NAMESPACE__ . '\text';

function time($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "time"]));
}

const time = __NAMESPACE__ . '\time';

function url($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "url"]));
}

const url = __NAMESPACE__ . '\url';

function week($attributes = []) {
  return element("input", "", Arr\merge($attributes, ["type" => "week"]));
}

const week = __NAMESPACE__ . '\week';

function label($content, $attributes = []) {
	return element("label", $content, $attributes);
}

const label = __NAMESPACE__ . '\label';

function legend($content, $attributes = []) {
	return element("legend", $content, $attributes);
}

const legend = __NAMESPACE__ . '\legend';

function meter($content, $attributes = []) {
	return element("meter", $content, $attributes);
}

const meter = __NAMESPACE__ . '\meter';

function optgroup($content, $attributes = []) {
	return element("optgroup", $content, $attributes);
}

const optgroup = __NAMESPACE__ . '\optgroup';

function option($content, $attributes = []) {
	return element("option", $content, $attributes);
}

const option = __NAMESPACE__ . '\option';

function output($content, $attributes = []) {
	return element("output", $content, $attributes);
}

const output = __NAMESPACE__ . '\output';

function progress($content, $attributes = []) {
	return element("progress", $content, $attributes);
}

const progress = __NAMESPACE__ . '\progress';

function select($content, $attributes = []) {
	return element("select", $content, $attributes);
}

const select = __NAMESPACE__ . '\select';

function textarea($content, $attributes = []) {
	return element("textarea", $content, $attributes);
}

const textarea = __NAMESPACE__ . '\textarea';


 
function element($type, $content, $attributes = []) {
    // $attributes = FP\extract($attributes);

    if(!is_array($attributes)) {
        return HTML\element($type, $content, $attributes);
    }

    if(isset($attributes["label"])) {
        if(is_array($attributes["label"])) {
            $label_text = $attributes["label"]["text"];
            $label_placement = isset($attributes["label"]["placement"]) 
                                ? $attributes["label"]["placement"]
                                : "before";
        } else {
            $label_text = $attributes["label"];
            $label_placement = isset($attributes["label_placement"]) 
                                ? $attributes["label_placement"]
                                : "before";
        }
    } else {
        $label_text = $attributes["name"];
        $label_placement = "before";
    }

    $label_for = isset($attributes["id"]) ? $attributes["id"] : $attributes["name"];

    unset($attributes["label"]);
    unset($attributes["label_class"]);

    $out = [
        HTML\label($label_text, ["for" => $label_for])
        , HTML\element($type, $content, $attributes)
    ];

    return $label_placement === "before" 
                ? implode($out)
                : implode(array_reverse($out));
}