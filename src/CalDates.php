<?php 

namespace lray138\GAS\CalDates;

use lray138\GAS\Functional as FP;
use lray138\GAS\DateTime as DT;
use lray138\GAS\Types\Time;
use lray138\GAS\Types\ArrType;
use lray138\GAS\Arr;
use lray138\GAS\Types as T;
use lray138\GAS\HTML;

use function lray138\GAS\dump;

// even this is kind of not descriptive now that I'm coming back to it
// although I guess I'd know.
function getYear($options = null) {
	if(is_null($options)) {
		$year = date("Y");
	} else if(is_array($options)) {
		$year = isset($options["year"]) ? $options["year"] : date("Y");
	} else if(is_string($options)) {
		$year = $options;
	}
	return array_map(getYearMonthDates($year), range(1, 12));
}

const getYear = __NAMESPACE__ . '\getYear';

// this was created before the types was really dialed in
// so, I would expect now that maybe Calendar should be a class anyway... dunno... not really
// but... this should return the Type array is what I would expect...
// if it relies on Time type, maybe that makes it appropriate for that.
function getYearMonthDates() {
	$getYearMonthDates = function($year, $month) {

		$first_day_of_week = DT\firstDayOfWeek($year, $month);
		$days_in_month = DT\daysInMonth($year, $month);
		$weeks_in_month = DT\weeksInMonth($year, $month);

		$rows = [];

		for($i = 0; $i < $weeks_in_month; $i++) {
			$row = [];

			if($i === 0) {
				//$current_day = gmp_neg($first_day_of_week - 1);
				if($first_day_of_week == 7) {
					$current_day = 1;
				} else {
					$current_day = gmp_neg($first_day_of_week - 1);
				}
			}

			for($j = 1; $j <= 7; $j++) {
				if($current_day <= 0) {
					$date_time = (new Time($year . "-" . $month . "-01"))->add(date_interval_create_from_date_string(($current_day-1) . ' days'));
					$current_month = false;
				} elseif($current_day > $days_in_month) {
					$date_time = (new Time($year . "-" . $month . "-" . $days_in_month))->add(date_interval_create_from_date_string(($current_day-$days_in_month) . ' days'));
					$current_month = false;
				} else {
					$date_time = (new Time($year . "-" . $month . "-" . $current_day));
					$current_month = true;
				}

				$row[] = [
					"current_month" => $current_month,
					"date_time" => $date_time,
				];

				$current_day++;
			}

			$rows[] = $row;
		}

		return ArrType::of($rows);
	};

	return call_user_func_array(FP\curry2($getYearMonthDates), func_get_args());
}

function getOccuredWeekDates($year, $week_num) {
	
}

function getWeeksInMonth($year, $month) {

}

function getMonthDates($year, $month) {
	
}

function getDaysInMonth($year, $month) {
	return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

function getMonthName($num) {
	return getMonthNames()[$num];
}

// I modified this
// https://www.apharmony.com/software-sagacity/2014/07/php-one-liners-array-of-month-names-and-numbers/
// "get all month names???"
function getMonthNames() {
	$fn = function($m) { 
		return date('F', mktime(0, 0, 0, $m, 10));
	};

	return array_map($fn, range(1,12));
}

function getMonthNamesShort() {
	return array_map(function($x) {
		return substr($x, 0, 3);
	}, getMonthNames());
}

// originally this was set to accept \Time month
// I don't like that anymore 
function create($time = null, $month = '') {

	if(is_null($time)) {
		$year = (new \DateTime())->format("YYYY");
	} else {

		if(is_object($time)) {
			return getYearMonthDates($time->getYYYY(), $time->getMM());
		}

		$year = is_object($time)
			? $time->format("YYYY")
			: $time;
	}

	$args = [$year];

	if(!empty($month)) {
		$args[] = $month;
	}

	//return getYearMonthDates($time->getYYYY(), $time->getMM());
	return call_user_func(__NAMESPACE__ . "\getYearMonthDates", ...$args);
};

function fromDateTime(\DateTime $time = null) {
	$time = is_null($time) 
		? new Time()
		: $time;

	return getYearMonthDates($time->format("Y"), $time->format("m"));
};

function fromYearMonth() {
	$f = function($year, $month) {
		return getYearMonthDates($year, $month);
	};
	return FP\curryN(2, $f)(...func_get_args());
}

function getWeekDays($start = "Sun") {
	$days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

	if($start !== "Sun") {
		$day = array_shift($days);
		$days[] = $day;
	}

	return $days;
}

function getWeekDaysShort($start = "Sun") {
	return Arr\map(function($x) {
		return substr($x, 0, 3);
	}, getWeekDays($start));
}

function findDate($monthDates, $datetime) {
	foreach($monthDates as $week_key => $week) {
		foreach($week as $day_key => $day) {
			if($datetime->format("Y-m-d") == $day["date_time"]->format("Y-m-d")) {
				return [
					"week_key" => $week_key,
					"day_key" => $day_key
				];
			}

		}
	}
}