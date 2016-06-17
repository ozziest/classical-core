<?php namespace Ozziest\Core\HTTP;

interface IResponse {
    
    /**
     * This method shows a view with blade template engine
     * 
     * @param  string   $name
     * @param  array    $arguments
     * @param  integer  $status
     * @return null
     */
    public function view($name, $arguments = [], $status = 200);
    
    /**
     * This method shows a json data
     * 
     * @param  array    $data
     * @param  integer  $status
     * @return null
     */
    public function json($data, $status = 200);
    
    /**
     * This method shows a simple HTTP_OK status 
     * 
     * @return null
     */
    public function ok();
    
}