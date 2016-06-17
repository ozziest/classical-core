<?php namespace Ozziest\Core\HTTP;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Exception;

class Request implements IRequest {

    private $params;
    private $symfony;
    
    /**
     * Class constructor
     * 
     * @param  Symfony\Component\HttpFoundation\Request $request
     * @return null
     */
    public function __construct(SymfonyRequest $request)
    {
        $this->symfony = $request;
        $this->params = $request->request;
    }
    
    /**
     * This method returns the argument which is been in the url
     * 
     * @param  string   $key
     * @param  string   $default
     * @return string
     */
    public function getUrlParam($key, $default = null)
    {
        if (isset($this->symfony->parameters[$key]))
        {
            $default = $this->symfony->parameters[$key];
        }
        return $default;
    }
    
    /**
     * This method returns all argument as an array
     * 
     * @return array
     */
    public function all()
    {
        return $this->params->all();
    }
    
    /**
     * This method returns the argument which is selected
     * 
     * @param  string   $name
     * @param  string   $default
     * @return string
     */
    public function get($name, $default = null)
    {
        try {
            $default = $this->params->get($name);
        }
        catch (Exception $exception) {
            
        }
        return $default;
    }    

}