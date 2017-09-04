<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__ .'/../../vendor/autoload.php');

require_once './include/cloudinary.php';
require_once './include/classredishelper.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('javaclass');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

if (file_exists('.test')) {
  require_once './include/cloudinary_local.php';
}

if($_ENV['REDIS_URL']) {
  $redisUrlParts = parse_url($_ENV['REDIS_URL']);
  ini_set('session.save_handler','redis');
  ini_set('session.save_path',"tcp://$redisUrlParts[host]:$redisUrlParts[port]?auth=$redisUrlParts[pass]");
}

?>
