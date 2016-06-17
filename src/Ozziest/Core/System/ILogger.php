<?php namespace Ozziest\Core\System;

interface ILogger {
    
    /**
     * This method puts a new error log
     * 
     * @param  string       $message
     * @return null
     */
    public function error($message);

    /**
     * This method puts a new warning log
     * 
     * @param  string       $message
     * @return null
     */
    public function warning($message);

    /**
     * This method puts a new log with exception
     * 
     * @param  Exception       $exception
     * @return null
     */
    public function exception($exception);
    
}