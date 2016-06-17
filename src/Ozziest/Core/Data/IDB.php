<?php namespace Ozziest\Core\Data;

interface IDB {
    
    /**
     * This method creates a connection with database
     * 
     * @return null
     */
    public function connect();
    
    /**
     * This method creates a new transaction
     * 
     * @return null
     */
    public function transaction();
    
    /**
     * This method commits all changes
     * 
     * @return null
     */
    public function commit();
    
    /**
     * This method cancels the transaction
     * 
     * @return null
     */
    public function rollback();
    
    /**
     * This method returns the Eloqeunt connection
     * 
     * @see    https://laravel.com/api/5.1/Illuminate/Contracts/Container/Container.html
     * @return Illuminate\Contracts\Container\Container
     */
    public function get();
    
    /**
     * This method runs a raw query 
     * 
     * @param  string   $sql
     * @param  array    $arguments
     * @return mixed
     */
    public function query($sql, $arguments = array());
    
}