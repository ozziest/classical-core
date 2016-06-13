<?php namespace Ozziest\Core\Tests\Helpers;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Helpers\HttpHelper;

class HttpHelperTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }

    public function testHttpHelper()
    {
        $this->assertEquals(HttpHelper::ip(), 'UNKNOWN');

        $_SERVER["HTTP_USER_AGENT"] = 'chrome';
        $this->assertEquals(HttpHelper::agent(), 'chrome');
        $this->assertEquals(HttpHelper::agentMd5(), md5('chrome'));
    }

}