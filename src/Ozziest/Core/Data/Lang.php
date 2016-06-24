<?php namespace Ozziest\Core\Data;

class Lang {

    private static $lang;
    private static $items;

    public static function set($lang)
    {
        self::$lang = $lang;
        $file = ROOT.'resource/languages/'.$lang.'.php';
        self::$items = include($file);
    }
    
    public static function get($key)
    {
        if (isset(self::$items[$key]))
        {
            $key = self::$items[$key];
        }
        return $key;
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