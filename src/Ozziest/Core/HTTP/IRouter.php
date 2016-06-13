<?php namespace Ozziest\Core\HTTP;

interface IRouter {
    
    /**
     * This method sets the controller namespace
     * 
     * @param  string   $parentNamespace
     * @return null
     */
    public function setNamespace($parentNamespace);
    
    /**
     * This method define a route
     * 
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @param  string   $method
     * @return null
     */
    public function any($url, $controller, $action, $method = 'GET');
    
    /**
     * This method define a GET route
     * 
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @return null
     */
    public function get($url, $controller, $action);
    
    /**
     * This method define a POST route
     * 
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @return null
     */
    public function post($url, $controller, $action);
    
    /**
     * This method returns the route collection
     * 
     * @return Symfony\Component\Routing\RouteCollection
     */
    public function getCollection();
    
    /**
     * This method defines a middleware 
     * 
     * @param  string       $options
     * @param  function     $function
     * @return null
     */
    public function middleware($options, $function);

}