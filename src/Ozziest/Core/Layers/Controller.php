<?php namespace Ozziest\Core\Layers; 

use Ozziest\Core\Data\IDB;
use Ozziest\Core\System\ILogger;

class Controller {
    
    protected $db;
    protected $logger;
    
    /**
     * Class constructor
     * 
     * @param  Ozziest\Core\Data\IDB        $db
     * @param  Ozziest\Core\System\ILogger  $logger
     * @return null
     */
    public function __construct(IDB $db, ILogger $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }
    
}