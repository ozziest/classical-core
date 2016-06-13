<?php namespace Ozziest\Core\Tests\Data;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Data\Statics;

class StaticsTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testStatics()
    {
        Statics::set('Period', [1, 2, 5, 10, 15, 30, 45, 60, 90, 120]);
        Statics::check('Period', 1);
        Statics::check('Period', 2);
        Statics::check('Period', 5);
        Statics::check('Period', 10);
        Statics::check('Period', 120);
    }

    /**
     * @expectedException Ozziest\Core\Exceptions\UserException
     * @expectedExceptionMessage The Period is invalid!
     */
    public function testStaticsException()
    {
        Statics::check('Period', 666);
    }

}