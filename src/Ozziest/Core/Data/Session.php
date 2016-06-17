<?php namespace Ozziest\Core\Data;

class Session {

    public static function isLogged()
    {
        return self::get('is_logged') !== null;
    }
    
    public static function setUser($user)
    {
        self::set('the_user_id', $user->id);
        self::set('the_user_email', $user->email);
        self::set('the_user_name', $user->first_name.' '.$user->last_name);
        self::set('is_logged', true);
    }
    
    public static function clearUser()
    {
        self::set('the_user_id', null);
        self::set('the_user_email', null);
        self::set('the_user_name', null);
        self::set('is_logged', null);
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