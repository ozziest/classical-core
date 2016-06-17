<?php namespace Ozziest\Core\HTTP;

interface IRouter {

    /**
     * This method sets the controller namespace
     *
     * @param  string   $parentNamespace
     * @return null
     */
    public static function setNamespace($parentNamespace);

    /**
     * This method define a route
     *
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @param  string   $method
     * @return null
     */
    public static function any($url, $controller, $action, $method = 'GET');

    /**
     * This method define a GET route
     *
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @return null
     */
    public static function get($url, $controller, $action);

    /**
     * This method define a POST route
     *
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @return null
     */
    public static function post($url, $controller, $action);

    /**
     * This method returns the route collection
     *
     * @return Symfony\Component\Routing\RouteCollection
     */
    public static function getCollection();

    /**
     * This method defines a middleware
     *
     * @param  string       $options
     * @param  function     $function
     * @return null
     */
    public static function middleware($options, $function);

}
