<?php
require_once('./include/composer.php');
require_once('./include/classredishelper.php');

$redi = new PRedisHelper();
function test(){
    global $TimeZone;
    $today = new Datetime('now', new DateTimeZone($TimeZone));
    echo $today;    
}

test();

?>