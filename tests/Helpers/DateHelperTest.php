<?php namespace Ozziest\Core\Tests\Helpers;

use PHPUnit_Framework_TestCase;
use Mockery, DateTime, DateInterval;
use Ozziest\Core\Helpers\DateHelper;

class DateHelperTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }

    public function testDateHelper()
    {
        $value = (new DateTime())->add(new DateInterval('PT30M'))->format('Y-m-d H:i:s');
        $this->assertTrue(DateHelper::getExpiredDate() == $value);
    }

}