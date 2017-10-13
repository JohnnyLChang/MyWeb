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
    private $urlfmt1 = "https://res.cloudinary.com/hiw54u1hl/image/upload/c_crop,h_280,w_1080,x_30,y_%d/v1504623069/%s.png";
    private $urlfmt2 = "https://res.cloudinary.com/hiw54u1hl/image/upload/c_crop,h_280,w_1250,x_1050,y_%d/v1504623069/%s.png";
    private $log;

    private $classdata = array(
        927 => array(1040, "class2_iahadd"),
        928 => array(1230, "class2_iahadd"),
        929 => array(1390, "class2_iahadd"),
        930 => array(1590, "class2_iahadd"),
        1002 => array(1800, "class2_iahadd"),
        1003 => array(2000, "class2_iahadd"),
        1005 => array(2200, "class2_iahadd"),
        1006 => array(2380, "class2_iahadd"),
        1011 => array(2550, "class2_iahadd"),
        1012 => array(2720, "class2_iahadd"),
        1013 => array(2900, "class2_iahadd"),
        1016 => array(3100, "class2_iahadd"),
        1017 => array(460, "class3_iahadd"),
        1018 => array(640, "class3_iahadd"),
        1019 => array(820, "class3_iahadd"),
        1023 => array(1020, "class3_iahadd"),
        1025 => array(1220, "class3_iahadd"),
        1026 => array(1420, "class3_iahadd"),
        1027 => array(1620, "class3_iahadd"),
        1030 => array(1820, "class3_iahadd"),
        1101 => array(2020, "class3_iahadd"),
        1102 => array(2220, "class3_iahadd"),
        1103 => array(2420, "class3_iahadd"),
        1106 => array(2620, "class3_iahadd"),
        1107 => array(2800, "class3_iahadd"),
        1109 => array(3000, "class3_iahadd"),
        1110 => array(3180, "class3_iahadd"),
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
        $obj = $this->GetClassIdx($today_now);
        $url1 = "";
        $url2 = "";
        $center = $obj[0];
        if ($center > 0) {
            $this->log->addInfo("Center is " . $center);
            $url1 = sprintf($this->urlfmt1, $center-150, $obj[1]);
            $url2 = sprintf($this->urlfmt2, $center-150, $obj[1]);
            return array($url1, $url2);
        }
        return array(null, null);
    }
    
    public function __destruct()
    {
    }
}
