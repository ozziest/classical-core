<?php namespace Ozziest\Core\Tests\HTTP;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\HTTP\Request;

class RequestTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
    
    public function test_init_ok()
    {
        $subRequest = Mockery::mock('subRequest');
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $request = new Request($symfonyRequest);
    }

    public function test_get_url_param_null()
    {
        $subRequest = Mockery::mock('subRequest');
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $request = new Request($symfonyRequest);
        
        $value = $request->getUrlParam('my_key');
        $this->assertEquals($value, null);
    }

    public function test_get_url_param_default()
    {
        $subRequest = Mockery::mock('subRequest');
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $request = new Request($symfonyRequest);
        
        $value = $request->getUrlParam('my_key', 'default');
        $this->assertEquals($value, 'default');
    }

    public function test_get_url_param_ok()
    {
        $subRequest = Mockery::mock('subRequest');
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $symfonyRequest->parameters = [
            'my_key' => 'secret_value'
        ];
        $request = new Request($symfonyRequest);
        
        $value = $request->getUrlParam('my_key', 'default');
        $this->assertEquals($value, 'secret_value');
    }

    public function test_all_ok()
    {
        $subRequest = Mockery::mock('subRequest');
        $subRequest->shouldReceive('all')->times(1)->andReturn('ok');
        
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $request = new Request($symfonyRequest);
        
        $value = $request->all();
        $this->assertEquals($value, 'ok');
    }

    public function test_get_null()
    {
        $subRequest = Mockery::mock('subRequest');
        $subRequest->shouldReceive('get')->times(1)->with('my_key')->andThrow(Exception);
        
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $request = new Request($symfonyRequest);
        
        $value = $request->get('my_key');
        $this->assertEquals($value, null);
    }

    public function test_get_default()
    {
        $subRequest = Mockery::mock('subRequest');
        $subRequest->shouldReceive('get')->times(1)->with('my_key')->andThrow(Exception);
        
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $request = new Request($symfonyRequest);
        
        $value = $request->get('my_key', 'my_default');
        $this->assertEquals($value, 'my_default');
    }

    public function test_get_ok()
    {
        $subRequest = Mockery::mock('subRequest');
        $subRequest->shouldReceive('get')->times(1)->with('my_key')->andReturn('value');
        
        $symfonyRequest = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $symfonyRequest->request = $subRequest;
        $request = new Request($symfonyRequest);
        
        $value = $request->get('my_key', 'my_default');
        $this->assertEquals($value, 'value');
    }
    
}