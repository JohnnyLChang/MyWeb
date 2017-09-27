<?php
namespace tests;

require ('JavaClass/ClassUrlHelper.php');

use JavaClass;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PHPUnit\Framework\TestCase;
use DateTime;

class JavaClassTest extends TestCase
{
    private $log;

    public function setup()
    {
        $this->log = new Logger(__CLASS__);
        $this->log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));
    }

    public function testJavaClassIdx()
    {
        $class = new JavaClass\ClassUrlHelper($this->log);
        $d1 =  $class->GetClassIdx(new DateTime('2017-9-27'));
        $d2 =  $class->GetClassIdx(new DateTime('2017-9-28'));
        $d3 =  $class->GetClassIdx(new DateTime('2017-9-29'));
        $this->assertGreaterThan(0, $d1[0]);
        $this->assertGreaterThan(0, $d2[0]);
        $this->assertGreaterThan(0, $d3[0]);
    }

    public function testJavaClassUrl()
    {
        $class = new JavaClass\ClassUrlHelper($this->log);
        list($u1, $u2) =  $class->GetClassUrl(new DateTime('2017-9-27'));
        $this->assertNotNull($u1);
        $this->assertNotNull($u2);
        list($u1, $u2) =  $class->GetClassUrl(new DateTime('2017-9-28'));
        $this->assertNotNull($u1);
        $this->assertNotNull($u2);
        list($u1, $u2) =  $class->GetClassUrl(new DateTime('2017-9-29'));
        $this->assertNotNull($u1);
        $this->assertNotNull($u2);
        $this->log->addInfo($u1);
        $this->log->addInfo($u2);
    }
}
