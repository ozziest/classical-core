<?php namespace Ozziest\Core\Data;

class Lang {

    private static $lang;

    public static function set($lang)
    {
        self::$lang = $lang;
    }

    public static function is($lang)
    {
        return self::$lang === $lang;
    }

    public static function current()
    {
        return self::$lang;
    }
    
}