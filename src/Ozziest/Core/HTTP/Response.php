<?php namespace Ozziest\Core\HTTP;

use Philo\Blade\Blade;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Response implements IResponse {

    private $engine;
    private $request;
    
    /**
     * Class constructor
     * 
     * @param  Symfony\Component\HttpFoundation\Request     $request
     * @param  Symfony\Component\HttpFoundation\Response    $response
     * @param  Philo\Blade\Blade                            $blade
     * @return null
     */
    public function __construct(SymfonyRequest $request, SymfonyResponse $response, Blade $blade)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->engine   = $blade;
    }
    
    /**
     * This method shows a view with blade template engine
     * 
     * @param  string   $name
     * @param  array    $arguments
     * @param  integer  $status
     * @return null
     */
    public function view($name, $arguments = [], $status = 200)
    {
        $content = $this->get($name, $arguments);
        $this->putResponse($content, $status, 'text/html');
    }
    
    /**
     * This method shows a json data
     * 
     * @param  array    $data
     * @param  integer  $status
     * @return null
     */
    public function json($data, $status = 200)
    {
        $content = json_encode($data);
        $this->putResponse($content, $status, 'application/json');
    }
    
    /**
     * This method shows a simple HTTP_OK status 
     * 
     * @return null
     */
    public function ok()
    {
        $this->putResponse("", 200, 'application/json');
    }
    
    /**
     * This method prepare the Symfony response object
     * 
     * @param  string   $content
     * @param  integer  $status
     * @param  string   $type
     * @return null
     */
    private function putResponse($content, $status, $type)
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->headers->set('Content-Type', $type);
        $this->response->prepare($this->request);
        $this->response->setPublic();
        $this->response->setMaxAge(600);
        $this->response->send();
    }

    /**
     * This method prepare the view with blade engine
     * 
     * @param  string   $name
     * @param  array    $arguments
     * @return string
     */
    private function get($name, $arguments = [])
    {
        return $this->engine->view()->make($name, $arguments)->render();
    }

}