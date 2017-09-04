<?php
require_once './include/composer.php';

use Predis;
$redis = new Predis\Client(getenv('REDIS_URL'));

$c = new CloudImages();
$local_path = "./images/5_class_1.png";
$image_id = "5_class_1";
$res=$c->UploadLocalToCloudFile($local_path, $image_id);
if($res['success']==1) {
    $log->addInfo("file successfully Upload" . $res["surl"]);
}else { 
    $log->addWarning($res['data']);
}
?>