<?php
require_once './include/composer.php';

class JavaClassBase{
    private $log;
    
    public function __construct(){
        $this->log = new Logger("java");
        $this->log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));
    }
}
?>