<?php namespace Ozziest\Core\Data;

class Session {
    
    public static function setRequestData($data)
    {
        self::set('request_data', $data);
    }

    public static function value($key)
    {
        $data = self::get('request_data');
        self::set('request_data', null);
        if ($data === null)
        {
            return '';
        }
        
        if (isset($data[$key]) === false)
        {
            return '';
        }
        
        return $data[$key];
    }
    
    public static function isLogged()
    {
        return self::get('is_logged') !== null;
    }
    
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