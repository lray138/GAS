<?php 

namespace lray138\GAS\Calendar;

use lray138\GAS\Functional as FP;
use lray138\GAS\DateTime as DT;

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
					$date_time = (new \DateTime($year . "-" . $month . "-01"))->add(date_interval_create_from_date_string(($current_day-1) . ' days'));
					$current_month = false;
				} elseif($current_day > $days_in_month) {
					$date_time = (new \DateTime($year . "-" . $month . "-" . $days_in_month))->add(date_interval_create_from_date_string(($current_day-$days_in_month) . ' days'));
					$current_month = false;
				} else {
					$date_time = (new \DateTime($year . "-" . $month . "-" . $current_day));
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

		return $rows;
	};

	return call_user_func_array(FP\curry2($getYearMonthDates), func_get_args());
}

function getWeekDates($year, $week_num) {

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
