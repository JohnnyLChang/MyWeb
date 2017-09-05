<?php
require_once('./include/composer.php');
require_once('./include/classredishelper.php');
require_once('./heroku.php');

$im = imagecreatefrompng('./images/class_schedule.png');

for ($x = 3; $x <= 18; $x++) {
    $offset = $x; 
    $id_morning = $offset . "_class_1";
    $id_afternoon = $offset . "_class_2";
    $file_morning = "/tmp/" . $offset . "_class_1.png";
    $file_afternoon = "/tmp/" . $offset . "_class_2.png";

    $center = $classoffset[$offset];
    $im_morning = imagecrop($im, ['x' => 80, 'y' => $center-150, 'width' => 1560, 'height' => 300]);
    if ($im_morning !== false) {
        imagepng($im_morning, $file_morning);
        echo "Create for $x\n";
    }
} 
?>