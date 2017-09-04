<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__ .'/../../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PRedisHelper{
    protected $redis;
    protected $log;
    
    public function __construct() {
        try{
            $this->redis = new Predis\Client(getenv('REDIS_URL'));
            $this->log = new Logger('redis');
            $this->log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));
            $this->log->addInfo("Logger created");
            if(false == $this->redis->isConnected()){
                $this->log->addWarning("redis not connected");
                $this->redis->connect();
            }
        }
        catch (Exception $e) {
            error_log("Couldn't connected to Redis");
            error_log($e->getMessage());
        }
        
    }
    
    public function GetUrl($tag){
        if($this->redis->exists($tag))
            return $this->redis->get($tag);
            $this->log->addWarn("get " . $tag . " not found");
    }

    public function Exists($tag){
        return $this->redis->exists($tag);
    }

    public function SetUrl($tag, $url){
        $ret = $this->redis->set($tag, $url);
        if(false == $ret){
            $this->log->addWarn("set " . $tag . " with " . $url . "failed");
        }
    }
}
?>