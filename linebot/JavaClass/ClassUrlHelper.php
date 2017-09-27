<?php
namespace JavaClass;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ .'/JavaClass/ClassUrlHelper.php');

if (file_exists('.test')) {
    require_once 'common.php';
} else {
    require_once 'heroku.php';
}

class ClassUrlHelper
{
    private $urlfmt1 = "https://res.cloudinary.com/hiw54u1hl/image/upload/c_crop,h_300,w_1560,x_80,y_%d/v1504623069/class_schedule_hetios.png";
    private $urlfmt2 = "https://res.cloudinary.com/hiw54u1hl/image/upload/c_crop,h_300,w_1560,x_1640,y_%d/v1504623069/class_schedule_hetios.png";
    private $log;

    private $classdata = array(
        911 => 2605,
        912 => 2920,
        913 => 3200,
        914 => 3500,
        915 => 3780,
        918 => 4090,
        919 => 4395,
        920 => 4690,
        922 => 5540,
        925 => 5840,
        926 => 6140,
        927 => 6440,
        929 => 6740,
        930 => 7040,
    );
    public function __construct($log)
    {
        $this->log = $log;
    }

    public function GetClassIdx($mydate)
    {
        $month = $mydate->format('m');
        $day = $mydate->format('d');
        $index = $month*100+$day;
        $this->log->addInfo("Class date " . $mydate->format('Y-m-d') . " Idx is " . $index);
        if (array_key_exists($index, $this->classdata)) {
            return $this->classdata[$index];
        } else {
            return 0;
        }
    }

    public function GetClassUrl($today_now)
    {
        $center = $this->GetClassIdx($today_now);
        $url1 = "";
        $url2 = "";
        if ($center > 0) {
            $this->log->addInfo("Center is " . $center);
            $url1 = sprintf($this->urlfmt1, $center-150);
            $url2 = sprintf($this->urlfmt2, $center-150);
            return array($url1, $url2);
        }
        return array(null, null);
    }
    
    public function __destruct()
    {
    }
}
