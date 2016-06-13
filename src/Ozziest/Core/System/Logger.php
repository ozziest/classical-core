<?php namespace Ozziest\Core\System;

use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;
use DateTime;

class Logger implements ILogger {
    
    private $logger;
    
    /**
     * Class constructor
     * 
     * @param  Monolog\Logger   $logger
     * @return null
     */
    public function __construct(MonoLogger $logger)
    {
        $this->logger = $logger;
        $file = (new DateTime())->format('Y-m-d').'.log';
        $this->logger->pushHandler(new StreamHandler(ROOT.'resource/logs/'.$file, MonoLogger::WARNING));
    }
    
    /**
     * This method puts a new error log
     * 
     * @param  string       $message
     * @return null
     */
    public function error($message)
    {
        $this->logger->addError($message);        
    }

    /**
     * This method puts a new warning log
     * 
     * @param  string       $message
     * @return null
     */
    public function warning($message)
    {
        $this->logger->addWarning($message);        
    }
    
    /**
     * This method puts a new log with exception
     * 
     * @param  Exception       $exception
     * @return null
     */
    public function exception($exception)
    {
        $this->logger->addError(
            '['.$exception->getCode().'] '.$exception->getMessage()."\n".
            $exception->getFile().": ".$exception->getLine()."\n".
            $exception->getTraceAsString()
        );
    }
    
}