<?php namespace Ozziest\Core\Tests\Data;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Data\Lifecycle;

class LifecycleTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testLifeCycle()
    {
        $data = Lifecycle::get('my_data');
        $this->assertEquals($data->id, -1);
        
        Lifecycle::set('my_data', ['id' => 666]);

        $data = Lifecycle::get('my_data');
        $this->assertEquals($data->id, 666);
    }
    
}