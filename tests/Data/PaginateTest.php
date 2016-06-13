<?php namespace Ozziest\Core\Tests\Data;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Data\Paginate;

class PaginateTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }

    /**
     * @dataProvider paginateProvider
     */
    public function testPaginate($total, $current)
    {
        $skip = Mockery::mock('skip')
                       ->shouldReceive('get')
                       ->andReturn([
                           ['id' => 1, 'name' => 'John']
                         ])
                       ->mock();
        
        $take = Mockery::mock('take')
                       ->shouldReceive('skip')
                       ->andReturn($skip)
                       ->mock();
        
        $query = Mockery::mock('foo')
                        ->shouldReceive('count')
                        ->andReturn($total)
                        ->shouldReceive('take')
                        ->andReturn($take)
                        ->mock();

        $request = Mockery::mock('Ozziest\Core\HTTP\IRequest')
                          ->shouldReceive('getUrlParam')
                          ->andReturn($current)
                          ->mock();
        
        $data = Paginate::get($query, $request);

        $this->assertEquals($data->total, $total);
        $this->assertEquals($data->pages, ceil($total / 10));
        $this->assertEquals($data->current, $current);
        $this->assertEquals(count($data->data), 1);
    }
    
    public function paginateProvider()
    {
        return array(
            // total, skip
            array(10, 1),
            array(100, 1),
            array(78, 1),
            array(158, 2),
        );
    }      
    
}