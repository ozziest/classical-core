<?php namespace Ozziest\Core\Data;

class Redirect {

    private static $db;

    public static function setDB($db)
    {
        self::$db = $db;
    }

    public static function to($route, $args = null)
    {
        if (substr($route, 0, 1) === "/")
        {
            $route = substr($route, 1);
        }

        // Arguments are being replacing
        if ($args !== null)
        {
            foreach ($args as $key => $arg)
            {
                $route = str_replace('{'.$key.'}', $arg, $route);
            }
        }

        self::$db->commit();
        header("Location: /".$route);
        die();
    }

}
