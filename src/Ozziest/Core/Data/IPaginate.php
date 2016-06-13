<?php namespace Ozziest\Core\Data;

use Ozziest\Core\HTTP\IRequest;

interface IPaginate {

    /**
     * This method paginates the quest result with page options which
     * request object has.
     * 
     * @param  object                       $query
     * @param  Ozziest\Core\HTTP\IRequest   $request
     * @return StdClass
     */
    public static function get($query, IRequest $request);
    
}