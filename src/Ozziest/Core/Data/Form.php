<?php namespace Ozziest\Core\Data;

use Ozziest\Core\HTTP\IRequest;
use Ozziest\Windrider\Windrider;

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
        
        if (is_array($data) === false || isset($data[$key]) === false)
        {
            return '';
        }
        
        return $data[$key];
    }
    
    public static function clear()
    {
        Session::set('request_data', null);
    }
    
    public static function validate(IRequest $request, $rules)
    {
        Windrider::runOrFail($request->all(), $rules);
    }
    
    public static function hasError()
    {
        return Session::get('validation_errors') !== null;
    }
    
    public static function getErrors()
    {
        $errors = Session::get('validation_errors');
        Session::set('validation_errors', null);
        return $errors;
    }
    
}