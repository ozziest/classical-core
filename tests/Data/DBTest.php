<?php namespace Ozziest\Core\Tests\Data;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Data\DB;

class DBTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testDB()
    {
        $getConnection = Mockery::mock('getConnection')
                                ->shouldReceive('beginTransaction')->times(1)
                                ->shouldReceive('commit')->times(1)
                                ->shouldReceive('rollBack')->times(1)
                                ->shouldReceive('raw')->times(1)
                                ->shouldReceive('select')->times(1)->andReturn(true)
                                ->mock();

        $capsule = Mockery::mock('Illuminate\Database\Capsule\Manager')
                          ->shouldReceive('addConnection')->times(1)
                          ->shouldReceive('bootEloquent')->times(1)
                          ->shouldReceive('getConnection')->andReturn($getConnection)->times(6)
                          ->mock();

        $db = new DB($capsule);
        
        $db->connect();
        $db->transaction();
        $db->commit();
        $db->rollBack();
        $db->get();
        $result = $db->query("SELECT * FROM users WHERE id = ?", [1]);
        $this->assertTrue($result);
        
    }

}