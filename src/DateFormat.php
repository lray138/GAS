<?php 

namespace lray138\GAS\DateFormat;

// https://www.php.net/manual/en/datetime.format.php

use lray138\GAS\Functional as FP;

/* 
	creating this on Jan 4th, 2022 because I feel like
	this should be split out and separated from 
	DateTime, where DateTime and some of the

	* there does seem to be a question about the semantics of
	date range vs. date timespan

	* how to think about formatting in terms of "day name short"
	  "day name long", "day name full", etc... 

	* 


	* it's July 6th 2024, I disagree with the above and think 
	it should just all be in DateTime
*/

function getYear(\DateTime $dt) {
	return $dt->format("Y");
}

function getMMM(\DateTime $dt) {
	return format(getMMMChar(), $dt);
}

function getMM(\DateTime $dt) {
	return format(getMMChar(), $dt);
}

function getMMChar() {
	return "m";
}

function getMMMChar() {
	return "M";
}

function getDDDChar() {
	return "D";
}

function getDDD(\DateTime $dt) {
	return $dt->format(getDDDChar());
}

function getD(\DateTime $dt) {
	return $dt->format("j");
}

function getDChar(): string {
	return "j";
}

function format() {
	$format = function($format, \DateTime $dt) {
		return $dt->format($format);
	};

	return call_user_func_array(FP\curry2($format), func_get_args());
}

function mysql($dt) {
	return format("Y-m-d H:i:s", $dt);
}

// i think it would be 

// getTimespan would only be hours
// getDateTimeSpan would be date and time
// getDateSpan would just be dates...

function getTimespanOLD(\DateTime $start, \DateTime $end, $options = []): string {
	$defaults = [
		"month" => getMMMChar(),
		"year" => "Y",
		"day" => getDChar()
	];

	$getValue = function($val) use ($options, $defaults) {
		return isset($options[$val])
			? $options[$val]
			: $defaults[$val];
	};

	$init = FP\curry2(function($bit, $date) use ($getValue) {
		return $date->format($getValue($bit));
	});

	$month = $init("month");
	$year = $init("year");
	$day = $init("day");

	if($year($start) === $year($end)) {
		if($month($start) === $month($end)) {
			if($day($start) === $day($end)) {
				return $month($start) . " " . $day($start) . ", ". $year($start);
			}

			return !isset($options["no_days"])
					? $month($start) . " " . $day($start) . " - " . $day($end) . ", " . $year($end)
					: $month($start) . " " . $year($end);
		} else {
			return $month($start) . " " . $day($start) . " - " . $month($end) . " " . $day($end) . ", " . $year($end);
		}
	} else {
		return FP\compose(
			Arr\join(" - "),
			Arr\map(function(\DateTime $d) use ($month, $day, $year) {
				return $month($d) . " " . $day($d) . ", " . $year($d);
			})
		)([$start, $end]);
	}
	return "";
}


function getTimeSpan(\DateTime $start, \DateTime $end, $options = []) {
	return $start->format("H:i") . " - " . $end->format("H:i");
}

function getDateTimeSpan(\DateTime $start, \DateTime $end, $options = []) {
	return mysql($start) . " - " . mysql($end);
}