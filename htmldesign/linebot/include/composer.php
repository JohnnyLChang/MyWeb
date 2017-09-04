<?php
require_once './vendor/autoload.php';

require_once './cloudinary/Cloudinary.php';
require_once './cloudinary/Uploader.php';
require_once './cloudinary/Api.php';

require_once './include/cloudinary.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

if (file_exists('.test')) {
  require_once './include/cloudinary_local.php';
}

?>
