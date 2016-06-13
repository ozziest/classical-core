<?php namespace Ozziest\Core\Layers; 

use Ozziest\Core\Data\IDB;
use Ozziest\Core\Data\ISession;
use Ozziest\Core\System\ILogger;

class Controller {
    
    protected $session;
    protected $db;
    protected $logger;
    
    /**
     * Class constructor
     * 
     * @param  Ozziest\Core\Data\ISession   $sesion
     * @param  Ozziest\Core\Data\IDB        $db
     * @param  Ozziest\Core\System\ILogger  $logger
     * @return null
     */
    public function __construct(ISession $session, IDB $db, ILogger $logger)
    {
        $this->session = $session;
        $this->db = $db;
        $this->logger = $logger;
    }
    
}