<?php namespace Ozziest\Core\Data;  

use Ozziest\Core\Exceptions\UserException;

class Session implements ISession {

    private $user = false;
    private $id;
    private $name;
    private $email;
    
    /**
     * Class constructor
     * 
     * @param StdClass  $user
     * @retur null
     */
    public function __construct($user)
    {
        $this->user  = $user;
        $this->id    = $this->id();
        $this->name  = $this->name();
        $this->email = $this->email();
    }
    
    /**
     * This method returns the id of the logged user
     * 
     * @return integer
     */
    public function id()
    {
        $this->isMustBeSet();
        return $this->user->id;
    }
    
    /**
     * This method returns full name of the logged user
     * 
     * @return string
     */
    public function name()
    {
        $this->isMustBeSet();
        $name = trim($this->user->first_name.' '.$this->user->last_name);
        if (strlen($name) === 0) {
            $name = self::email();
        }
        return $name;
    }
    
    /**
     * This method returns email of the logged user
     * 
     * @return string
     */
    public function email()
    {
        $this->isMustBeSet();
        return $this->user->email;
    }
    
    /**
     * This method returns user object
     * 
     * @return StdClass
     */
    public function get()
    {
        $this->isMustBeSet();
        return $this->user;
    }
    
    /**
     * This method checks the user object has set!
     * 
     * @return string
     */
    private function isMustBeSet()
    {
        if ($this->user === false)
        {
            throw new UserException("Oturum geçerli değil.", 401);
        }
    }

}