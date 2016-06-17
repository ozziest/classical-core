<?php namespace Ozziest\Core\Tests\System;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\System\DI;

class DITest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage DI Manager has not been set!
     */
    public function test_init_model_fail()
    {
        $user = DI::model('User');
    }


    public function test_init_model_ok()
    {
        $manager = Mockery::mock('Manager');
        $manager->shouldReceive('model')->times(1)->with('User')->andReturn('user instance');
        
        DI::setManager($manager);
        $user = DI::model('User');
        $this->assertEquals($user, 'user instance');
    }

}