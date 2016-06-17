<?php namespace Ozziest\Core\Data;

class Redirect {

    private static $db;

    public static function setDB($db)
    {
        self::$db = $db;
    }

    public static function to($route)
    {
        if (substr($route, 0, 1) === "/")
        {
            $route = substr($route, 1);
        }
        self::$db->commit();
        header("Location: /".$route);
        die();
    }

}
