<?php namespace Ozziest\Core\Data;

use Ozziest\Core\Exceptions\UserException;

class Statics {

    private static $list = [];
    
    /**
     * This method sets a data with a key
     * 
     * @param  string   $key
     * @param  string   $values
     * @return null
     */
    public static function set($key, $values)
    {
        self::$list[$key] = $values;
    }
    
    /**
     * This method checks the value was defined in the values array.
     * If the values was not defined, throw an Exception
     * 
     * @param  string   $key
     * @param  string   $value
     * @return null
     */
    public static function check($key, $value)
    {
        if (in_array($value, self::$list[$key]) === false)
        {
            throw new UserException("The {$key} is invalid!");
        }
    }
   
}