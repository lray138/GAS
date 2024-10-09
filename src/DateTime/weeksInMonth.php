<?php namespace lray138\GAS\DateTime;

const weeksInMonth = __NAMESPACE__ . '\weeksInMonth';

/**
 * Function description.
 */
function weeksInMonth(){                   
    $weeksInMonth = function($year, $month) {
        // find number of weeks in this month
        $daysInMonths = daysInMonth($year, $month);
    
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
        $monthEndingDay==7?$monthEndingDay=0:'';
        $monthStartDay==7?$monthStartDay=0:'';
    
        if($monthEndingDay < $monthStartDay){
            $numOfweeks++;
        }
        return $numOfweeks;
    };

    return call_user_func_array(FP\curry2($weeksInMonth), func_get_args());
}