<?php namespace Ozziest\Core\Data;

use Ozziest\Core\HTTP\IRequest;

class Paginate implements IPaginate {
    
    /**
     * This method paginates the quest result with page options which
     * request object has.
     * 
     * @param  object                       $query
     * @param  Ozziest\Core\HTTP\IRequest   $request
     * @return StdClass
     */
    public static function get($query, IRequest $request)
    {
        $total = $query->count();
        return (object) [
            'data'    => $query->take(10)->skip($request->getUrlParam('skip'))->get(),
            'total'   => $total,
            'pages'   => ceil($total / 10),
            'current' => (int) $request->getUrlParam('skip')
        ];
    }
    
}