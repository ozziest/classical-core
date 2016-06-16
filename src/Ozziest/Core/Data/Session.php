<?php namespace Ozziest\Core\Data;

class Session {
    
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null)
    {
        if (isset($_SESSION[$key]))
        {
            $default = $_SESSION[$key];
        }
        return $default;
    }
    
}