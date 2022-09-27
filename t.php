<?
//function getSundays($y,$m){ 
//    $date = "$y-$m-01";
//    $first_day = date('N',strtotime($date));
//    $first_day = 7 - $first_day + 1;
//    $last_day =  date('t',strtotime($date));
//    $days = array();
//    for($i=$first_day; $i<=$last_day; $i=$i+7 ){
//        $days[] = $i;
//    }
//    return  $days;
//}
//
//$days = getSundays(2016,04);
//print_r($days);


function getDays($year, $startMonth=1, $startDay=1, $dayOfWeek='monday') {
    $start = new DateTime(
        sprintf('%04d-%02d-%02d', $year, $startMonth, $startDay)
    );
    $start->modify($dayOfWeek);
    $end   = new DateTime(
        sprintf('%04d-12-31', $year)
    );
    $end->modify( '+1 day' );
    $interval = new DateInterval('P1W');
    $period   = new DatePeriod($start, $interval, $end);

    foreach ($period as $dt) {
        echo $dt->format("d/m/Y") . '<br />';
    }
}

echo getDays(2017, 1, 1, 'sunday');