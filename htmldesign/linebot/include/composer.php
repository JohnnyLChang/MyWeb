<?php
require './vendor/autoload.php';

require './cloudinary/Cloudinary.php';
require './cloudinary/Uploader.php';
require './cloudinary/Api.php';

require './include/cloudinary.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

if (file_exists('.test')) {
    require './include/cloudinary_local.php';
}

?>
