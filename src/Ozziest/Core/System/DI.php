<?php namespace Ozziest\Core\System;

use Exception;

class DI {
    
    private static $manager;
    
    /**
     * This method sets the DI manager
     * 
     * @param  mixed    $manager
     * @return null
     */
    public static function setManager($manager)
    {
        self::$manager = $manager;
    }
    
    /**
     * This method gets the model which was selected
     * 
     * @param  string       $name
     * @return mixed
     */
    public static function model($name)
    {
        self::check();
        return self::$manager->model($name);
    }
    
    /**
     * This method checks the DI Manager was set or not
     * 
     * @return null
     */
    private static function check()
    {
        if (isset(self::$manager) === false)
        {
            throw new Exception("DI Manager has not been set!");
        }
    }
    
}