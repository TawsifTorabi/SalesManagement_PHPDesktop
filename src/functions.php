<?php 
//monthly week
function weekOfMonth($date) {
    $firstOfMonth = date("Y-m-01", strtotime($date));
    return intval(date("W", strtotime($date))) - intval(date("W", strtotime($firstOfMonth)));
}

//yearly week
function getWeek($date) {
    $week = date('W',strtotime($date));
    $day  = date('N',strtotime($date));
    $max_weeks = getIsoWeeksInYear(date('Y',strtotime($date)));

    if($day == 7 && $week != $max_weeks) {
        return ++$week;
    } elseif($day == 7) {
        return 1;
    } else {
        return $week;
    }
	
}


function getCurrentIntervalOfWeek($liveratetime) {
    // get start of each week.
    $dayofweek = date('w', $liveratetime);
    $getdate = date('Y-m-d', $liveratetime);
    $createstart = strtotime('last Sunday', $liveratetime);
    $weekstart = ($dayofweek == 0) ? $liveratetime : $createstart;
    // get the current time interval for a week, i.e. Sunday 00:00:00 UTC
    $currentInterval = mktime(0,0,0, date('m', $weekstart), date('d', $weekstart), date('Y', $weekstart));
    return $currentInterval;
}

function getIsoWeeksInYear($year) {
    $date = new DateTime;
    $date->setISODate($year, 53);
    return ($date->format("W") === "53" ? 53 : 52);
}






	



?>