<?php namespace Ozziest\Core\System;

class DIManager {
    
    /**
     * This method creates a new model
     * 
     * @param  string   $name
     * @return mixed
     */
    public function model($name)
    {
        $name = 'App\Models\\'.$name;
        return new $name();
    }
    
}