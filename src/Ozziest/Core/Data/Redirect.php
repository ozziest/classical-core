<?php namespace Ozziest\Core\Data;

class Redirect {

    public static function to($route)
    {
        header("Location: /".$route);
        die();        
    }

}