<?php
require_once './include/composer.php';
ini_set('memory_limit', '1024M');

if (file_exists('.test')) {
    require_once 'common.php';
} else {
    require_once 'heroku.php';
}

function get_schedule()
{
    $d1 = new DateTime("2017-9-20");
    $d1 = new DateTime("2017-9-20");
    $d1 = new DateTime("2017-9-20");
    $d1 = new DateTime("2017-9-20");
    $d1 = new DateTime("2017-9-20");
    $d1 = new DateTime("2017-9-20");
    $interval = date_diff($today, $start_date);
    return $interval->format("%d");
}

function is_holiday($pdate)
{
    $not_holiday  = new DateTime("2017-9-30");
    $diff = date_diff($not_holiday, $pdate);
    if (0 == intval($diff->format("%a"))) {
        return false;
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
    $today = new DateTime('now');
    $interval = date_diff($today, $start_date);
    return $interval->format("%d");
}

function generate_class($today_now)
{
    global $url, $classoffset, $log;

    $start_date  = new DateTime("2017-8-31");
    $offset =  getWorkingDays($start_date, $today_now);
    $cloud = new CloudImages();
    $url1 = "";
    $url2 = "";
    $id_morning = $offset . "_class_1";
    $id_afternoon = $offset . "_class_2";
    $file_morning = "/tmp/" . $offset . "_class_1.png";
    $file_afternoon = "/tmp/" . $offset . "_class_2.png";

    if (!file_exists($file_morning)) {
        $im = imagecreatefrompng('./images/class_schedule.png');
        $center = $classoffset[$offset];
        $im_morning = imagecrop($im, ['x' => 80, 'y' => $center-150, 'width' => 1560, 'height' => 300]);
        if ($im_morning !== false) {
            imagepng($im_morning, $file_morning);
            $res=$cloud->UploadLocalToCloudFile($file_morning, $id_morning);
            if ($res['success']==1) {
                $log->addInfo("file successfully Upload" . $res["surl"]);
            } else {
                $log->addError($res['data']);
            }
        }
        
        $im_after = imagecrop($im, ['x' => 1640, 'y' => $center-150, 'width' => 1580, 'height' => 300]);
        if ($im_after !== false) {
            imagepng($im_after, $file_afternoon);
        }
    }
    return array($url1, $url2);
}

//$today = new DateTime('now');
