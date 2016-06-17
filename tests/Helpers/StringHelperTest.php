<?php namespace Ozziest\Core\Tests\Helpers;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Helpers\StringHelper;

class StringHelperTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }

    public function testStringHelper()
    {
        $this->assertTrue(strlen(StringHelper::random()) === 10);
    }

}