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
        self::set('the_user_slug', $user->slug);
        self::set('the_user_avatar', $user->avatar);
        self::set('the_user_authority', $user->authority);
        self::set('the_user_confirmation', $user->confirmation_code);
        self::set('is_logged', true);
    }

    public static function id()
    {
        return self::get('the_user_id');
    }

    public static function name()
    {
        return self::get('the_user_name');
    }

    public static function email()
    {
        return self::get('the_user_email');
    }

    public static function slug()
    {
        return self::get('the_user_slug');
    }

    public static function authority()
    {
        return self::get('the_user_authority');
    }

    public static function avatar()
    {
        return '/avatars/'.self::get('the_user_avatar');
    }

    public static function isAdmin()
    {
        return self::get('the_user_authority') == 'admin';
    }

    public static function isConfirmed()
    {
        return strlen(self::get('the_user_confirmation')) == 0;
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
