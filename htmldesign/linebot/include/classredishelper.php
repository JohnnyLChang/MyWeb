<?
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__ .'/../../vendor/autoload.php');

require_once('./include/composer.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Predis;

class PRedisHelper{
    private $redis;
    private $log;
    
    public function __construct() {
        $this->redis = new Predis\Client(getenv('REDIS_URL'));
        $this->log = new Logger('redis');
    }
    
    function GetUrl($tag){
        if($this->$redis->exists($tag))
            return $this->$redis->get($tag);
            $this->log->addWarn("get " . $tag . " not found");
    }

    function Exists($tag){
        return $this->$redis->exists($tag);
    }

    function SetUrl($tag, $url){
        $ret = $redis->set($tag, $url);
        if(false == $ret){
            $this->log->addWarn("set " . $tag . " with " . $url . "failed");
        }
    }
}

?>