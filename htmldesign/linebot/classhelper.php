<?php
require_once './include/composer.php';
require_once './include/classredishelper.php';

$res1 = "http://res.cloudinary.com/hiw54u1hl/image/upload/c_crop,h_300,w_1560,x_80,y_%d/v1504623069/class_schedule_hetios.png";
$res2 = "http://res.cloudinary.com/hiw54u1hl/image/upload/c_crop,h_300,w_1560,x_80,y_%d/v1504623069/class_schedule_hetios.png";

ini_set('memory_limit', '1024M');

if (file_exists('.test')) {
    require_once 'common.php';
} else {
    require_once 'heroku.php';
}

$redi = new PRedisHelper();

function is_holiday($pdate)
{
    $not_holiday  = new DateTime("2017-9-30");
    $is_holiday  = new DateTime("2017-9-21");
    $diff = date_diff($not_holiday, $pdate);
    if (0 == intval($diff->format("%a"))) {
        return false;
    }
    $diff = date_diff($is_holiday, $pdate);
    if (0 == intval($diff->format("%a"))) {
        return true;
    }    
    $when = strtotime($pdate->format('Y-m-d H:i:s'));
    $what_day = date("N", $when);
    if ($what_day > 5) {
        return true;
    } else {
        return false;
    }
}

function getWorkingDays($startDate, $endDate)
{
    $begin = strtotime($startDate->format('Y-m-d H:i:s'));
    $end   = strtotime($endDate->format('Y-m-d H:i:s'));
    if ($begin > $end) {
        return 0;
    } else {
        $no_days  = 0;
        $weekends = 0;
        while ($begin <= $end) {
            $no_days++; // no of days in the given interval
            $what_day = date("N", $begin);
            if ($what_day > 5) { // 6 and 7 are weekend days
                $weekends++;
            };
            $begin += 86400; // +1 day
        };
        $working_days = $no_days - $weekends;
        $not_holiday  = new DateTime("2017-9-30");
        $diff = date_diff($not_holiday, $endDate);
        $datediff = intval($diff->format("%R%a"));
        if ($datediff >= 0) {
            $working_days++;
        }
            
        return $working_days;
    }
}

function dateDifference($start_date)
{
    global $TimeZone;
    $today = new DateTime('now', new DateTimeZone($TimeZone));
    $interval = date_diff($today, $start_date);
    return $interval->format("%d");
}

function generate_class($today_now)
{
    global $url, $classoffset, $log, $redi, $res;

    $start_date  = new DateTime("2017-8-31");
    $offset =  getWorkingDays($start_date, $today_now);
    $center = $classoffset[$offset];
    $url1 = sprintf($res1, $center-150);
    $url2 = sprintf($res2, $center-150);
    
    return array($url1, $url2);
}

//$today = new DateTime('now');
