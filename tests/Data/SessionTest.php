<?php namespace Ozziest\Core\Tests\Data;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\Data\Session;

class SessionTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @expectedException Ozziest\Core\Exceptions\UserException
     */
    public function testException()
    {
        $session = new Session(false);
    }
    
    public function testCorrect()
    {
        $user = Mockery::mock('user');
        $user->id = 1;
        $user->first_name = 'Foo';
        $user->last_name  = 'Bar';
        $user->email      = 'foo@bar.com';
        
        $session = new Session($user);
        $this->assertEquals($session->id(), 1);
        $this->assertEquals($session->name(), 'Foo Bar');
        $this->assertEquals($session->email(), 'foo@bar.com');
    }

}