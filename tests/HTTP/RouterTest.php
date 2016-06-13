<?php namespace Ozziest\Core\Tests\HTTP;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\HTTP\Router;

class RouterTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }
    
    /**
     * @dataProvider routerProvider
     */
    public function testRouter($method, $url, $controller, $action)
    {
        Router::setNamespace('App\Controllers');
        Router::any($url, $controller, $action, strtoupper($method));
    }
    
    public function testRouteCollection()
    {
        $collection = Router::getCollection();
        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);
        $this->assertEquals($collection->count(), 2);
        foreach ($collection->all() as $key => $route)
        {
            $this->assertInstanceOf('Symfony\Component\Routing\Route', $route);
        }
    }
    
    public function routerProvider()
    {
        return array(
            // url, controller, action
            array('get', 'users', 'Users', 'getAll'),
            array('post', 'users/create', 'Users', 'create'),
        );
    }
    
}