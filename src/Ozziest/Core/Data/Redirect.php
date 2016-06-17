<?php namespace Ozziest\Core\Data;

class Redirect {
    
    public static function success($db, $route)
    {
        $db->commit();
        self::to($route);
    }

    public static function to($route)
    {
        if (substr($route, 0, 1) === "/")
        {
            $route = substr($route, 1);
        }
        header("Location: /".$route);
        die();        
    }
    
}