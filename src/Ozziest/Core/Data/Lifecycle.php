<?php namespace Ozziest\Core\Data;

class Lifecycle {

    private static $data = [];
    
    /**
     * This method sets a data to content
     * 
     * @param  string   $name
     * @param  string   $value
     * @return null
     */
    public static function set($name, $value)
    {
        self::$data[$name] = $value;
    }
    
    /**
     * This method gets the data if it was defined
     * 
     * @param  string   $name
     * @return StdClass
     */
    public static function get($name)
    {
        if (isset(self::$data[$name])) 
        {
            return (object) self::$data[$name];
        }
        return (object) [
            'id' => -1,
            'first_name' => '',
            'last_name' => '',
            'email' => ''
        ];
    }
    
}