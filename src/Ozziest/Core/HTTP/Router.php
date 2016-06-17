<?php namespace Ozziest\Core\HTTP;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class Router implements IRouter {

    private static $parentNamespace = "";
    private static $collection;
    private static $currentMiddlewares = [];

    /**
     * This method sets the controller namespace
     *
     * @param  string   $parentNamespace
     * @return null
     */
    public static function setNamespace($parentNamespace)
    {
        self::createFirst();
        self::$parentNamespace = $parentNamespace;
    }

    /**
     * This method define a route
     *
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @param  string   $method
     * @return null
     */
    public static function any($url, $controller, $action, $method = 'GET')
    {
        self::createFirst();
        $controller = self::$parentNamespace."\\".$controller;
        self::$collection->add(
            str_replace('\\', '.', $controller).'.'.$action, // name of the route
            new Route(
                $url,
                ['controller' => $controller, 'method' => $action, 'middlewares' => self::$currentMiddlewares],
                [], // requirements
                [], // options
                '', // host
                [], // schemes
                [$method] // methods
            )
        );
    }

    /**
     * This method define a GET route
     *
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @return null
     */
    public static function get($url, $controller, $action)
    {
        self::any($url, $controller, $action);
    }

    /**
     * This method define a POST route
     *
     * @param  string   $url
     * @param  string   $controller
     * @param  string   $action
     * @return null
     */
    public static function post($url, $controller, $action)
    {
        self::any($url, $controller, $action, 'POST');
    }

    /**
     * This method returns the route collection
     *
     * @return Symfony\Component\Routing\RouteCollection
     */
    public static function getCollection()
    {
        self::createFirst();
        return self::$collection;
    }

    /**
     * This method defines a middleware
     *
     * @param  string       $options
     * @param  function     $function
     * @return null
     */
    public static function middleware($options, $function)
    {
        self::createFirst();

        if (!is_array($options))
        {
            $options = [$options];
        }

        self::$currentMiddlewares = $options;
        $function();
        self::$currentMiddlewares = [];
    }

    /**
     * This method checks the collection was defined or not
     *
     * @return null
     */
    private static function createFirst()
    {
        if (isset(self::$collection) === false)
        {
            self::$collection = new RouteCollection();
        }
    }

}
