<?php namespace Ozziest\Core\HTTP;

interface IRequest {
    
    /**
     * This method returns the argument which is been in the url
     * 
     * @param  string   $key
     * @param  string   $default
     * @return string
     */
    public function getUrlParam($key, $default = null);
    
    /**
     * This method returns all argument as an array
     * 
     * @return array
     */
    public function all();
    
    /**
     * This method returns the argument which is selected
     * 
     * @param  string   $name
     * @param  string   $default
     * @return string
     */
    public function get($name, $default = null);
    
}