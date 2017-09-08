<?php
require_once('./include/composer.php');
require_once('./include/classredishelper.php');
require_once('./heroku.php');

$im = imagecreatefrompng('./images/class_schedule.png');

$res = "http://res.cloudinary.com/hiw54u1hl/image/upload/c_crop,h_300,w_1560,x_80,y_%d/v1504623069/class_schedule_hetios.png";

$images = array();

for ($x = 3; $x <= 17; $x++) {
    $center = $classoffset[$x];
    array_push( $images, sprintf($res, $center-150));
} 
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <?php foreach($images as $image):?>
    <img src="<?php echo ($image);?>"/><br/>
    <?php endforeach;?>
    </body>
</html>