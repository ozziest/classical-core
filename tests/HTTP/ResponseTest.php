<?php namespace Ozziest\Core\Tests\HTTP;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\HTTP\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
    
    public function test_init_ok()
    {
        $symfonyRequest  = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response');
        $blade           = Mockery::mock('Philo\Blade\Blade');
        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
    }

    public function test_view_ok()
    {
        $symfonyRequest  = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response');
        
        $symfonyResponse->headers = Mockery::mock('headers');
        $symfonyResponse->headers->shouldReceive('set')->times(1)->with('Content-Type', 'text/html');

        $symfonyResponse->shouldReceive('setContent')->times(1)->with('rendered');
        $symfonyResponse->shouldReceive('setStatusCode')->times(1)->with(200);
        $symfonyResponse->shouldReceive('prepare')->times(1)->with($symfonyRequest);
        $symfonyResponse->shouldReceive('setPublic')->times(1);
        $symfonyResponse->shouldReceive('setMaxAge')->times(1)->with(600);
        $symfonyResponse->shouldReceive('send')->times(1);

        $blade           = Mockery::mock('Philo\Blade\Blade');
        
        $blade->shouldReceive('view')
            ->times(1)
            ->andReturn($blade);
            
        $blade->shouldReceive('make')
            ->times(1)
            ->with('hello', [])
            ->andReturn($blade);
        
        $blade->shouldReceive('render')
            ->times(1)
            ->andReturn('rendered');
        
        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
        
        $response->view('hello');
    }
    
    public function test_view_with_args_ok()
    {
        $symfonyRequest  = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response');
        
        $symfonyResponse->headers = Mockery::mock('headers');
        $symfonyResponse->headers->shouldReceive('set')->times(1)->with('Content-Type', 'text/html');

        $symfonyResponse->shouldReceive('setContent')->times(1)->with('rendered');
        $symfonyResponse->shouldReceive('setStatusCode')->times(1)->with(200);
        $symfonyResponse->shouldReceive('prepare')->times(1)->with($symfonyRequest);
        $symfonyResponse->shouldReceive('setPublic')->times(1);
        $symfonyResponse->shouldReceive('setMaxAge')->times(1)->with(600);
        $symfonyResponse->shouldReceive('send')->times(1);

        $blade           = Mockery::mock('Philo\Blade\Blade');
        
        $blade->shouldReceive('view')
            ->times(1)
            ->andReturn($blade);
            
        $blade->shouldReceive('make')
            ->times(1)
            ->with('hello', ['id' => 1])
            ->andReturn($blade);
        
        $blade->shouldReceive('render')
            ->times(1)
            ->andReturn('rendered');
        
        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
        
        $response->view('hello', ['id' => 1]);
    }    

    public function test_view_with_status_code_ok()
    {
        $symfonyRequest  = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response');
        
        $symfonyResponse->headers = Mockery::mock('headers');
        $symfonyResponse->headers->shouldReceive('set')->times(1)->with('Content-Type', 'text/html');

        $symfonyResponse->shouldReceive('setContent')->times(1)->with('rendered');
        $symfonyResponse->shouldReceive('setStatusCode')->times(1)->with(201);
        $symfonyResponse->shouldReceive('prepare')->times(1)->with($symfonyRequest);
        $symfonyResponse->shouldReceive('setPublic')->times(1);
        $symfonyResponse->shouldReceive('setMaxAge')->times(1)->with(600);
        $symfonyResponse->shouldReceive('send')->times(1);

        $blade           = Mockery::mock('Philo\Blade\Blade');
        
        $blade->shouldReceive('view')
            ->times(1)
            ->andReturn($blade);
            
        $blade->shouldReceive('make')
            ->times(1)
            ->with('hello', ['id' => 1])
            ->andReturn($blade);
        
        $blade->shouldReceive('render')
            ->times(1)
            ->andReturn('rendered');
        
        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
        
        $response->view('hello', ['id' => 1], 201);
    } 
    
    public function test_json_ok()
    {
        $symfonyRequest  = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response');
        
        $symfonyResponse->headers = Mockery::mock('headers');
        $symfonyResponse->headers->shouldReceive('set')->times(1)->with('Content-Type', 'application/json');

        $symfonyResponse->shouldReceive('setContent')->times(1);
        $symfonyResponse->shouldReceive('setStatusCode')->times(1)->with(200);
        $symfonyResponse->shouldReceive('prepare')->times(1)->with($symfonyRequest);
        $symfonyResponse->shouldReceive('setPublic')->times(1);
        $symfonyResponse->shouldReceive('setMaxAge')->times(1)->with(600);
        $symfonyResponse->shouldReceive('send')->times(1);

        $blade           = Mockery::mock('Philo\Blade\Blade');
        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
        
        $response->json(['status' => true]);
    }     

    public function test_ok_ok()
    {
        $symfonyRequest  = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyResponse = Mockery::mock('Symfony\Component\HttpFoundation\Response');
        
        $symfonyResponse->headers = Mockery::mock('headers');
        $symfonyResponse->headers->shouldReceive('set')->times(1)->with('Content-Type', 'application/json');

        $symfonyResponse->shouldReceive('setContent')->times(1)->with("");
        $symfonyResponse->shouldReceive('setStatusCode')->times(1)->with(200);
        $symfonyResponse->shouldReceive('prepare')->times(1)->with($symfonyRequest);
        $symfonyResponse->shouldReceive('setPublic')->times(1);
        $symfonyResponse->shouldReceive('setMaxAge')->times(1)->with(600);
        $symfonyResponse->shouldReceive('send')->times(1);

        $blade           = Mockery::mock('Philo\Blade\Blade');
        $response = new Response($symfonyRequest, $symfonyResponse, $blade);
        
        $response->ok();
    }     
    
}