<?php namespace Ozziest\Core\Data;

use Illuminate\Database\Capsule\Manager;

class DB implements IDB {

    private $capsule;
    
    /**
     * Class constructer 
     * 
     * @param  Illuminate\Database\Capsule\Manager $capsule
     * @return null
     */
    public function __construct(Manager $capsule)
    {
        $this->capsule = $capsule;
    }
    
    /**
     * This method creates a connection with database
     * 
     * @return null
     */
    public function connect()
    {
        $this->capsule->addConnection(array(
            'driver'    => 'mysql',
            'host'      => getenv('hostname'),
            'database'  => getenv('database'),
            'username'  => getenv('username'),
            'password'  => getenv('password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ));
        $this->capsule->bootEloquent();
    }
    
    /**
     * This method creates a new transaction
     * 
     * @return null
     */
    public function transaction()
    {
        $this->capsule->getConnection()->beginTransaction();
    }
    
    /**
     * This method commits all changes
     * 
     * @return null
     */
    public function commit()
    {
        $this->capsule->getConnection()->commit();
    }
    
    /**
     * This method cancels the transaction
     * 
     * @return null
     */
    public function rollback()
    {
        $this->capsule->getConnection()->rollBack();
    }
    
    /**
     * This method returns the Eloqeunt connection
     * 
     * @see    https://laravel.com/api/5.1/Illuminate/Contracts/Container/Container.html
     * @return Illuminate\Contracts\Container\Container
     */
    public function get()
    {
        return $this->capsule->getConnection();
    }
    
    /**
     * This method runs a raw query 
     * 
     * @param  string   $sql
     * @param  array    $arguments
     * @return mixed
     */
    public function query($sql, $arguments = array())
    {
        return $this->get()->select($this->get()->raw($sql), $arguments);
    }    

}