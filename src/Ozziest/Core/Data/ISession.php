<?php namespace Ozziest\Core\Data;

interface ISession {
    
    /**
     * This method returns the id of the logged user
     * 
     * @return integer
     */
    public function id();
    
    /**
     * This method returns full name of the logged user
     * 
     * @return string
     */
    public function name();
    
    /**
     * This method returns email of the logged user
     * 
     * @return string
     */
    public function email();
    
    /**
     * This method returns user object
     * 
     * @return StdClass
     */
    public function get();
    
}