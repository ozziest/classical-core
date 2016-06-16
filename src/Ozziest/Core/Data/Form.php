<?php namespace Ozziest\Core\Data;

class Form {
    
    public static function setRequestData($data)
    {
        Session::set('request_data', $data);
    }

    public static function value($key)
    {
        $data = Session::get('request_data');
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
    
    public static function clear()
    {
        Session::set('request_data', null);
    }
    
}