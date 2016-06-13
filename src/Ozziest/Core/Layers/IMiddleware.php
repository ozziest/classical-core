<?php namespace Ozziest\Core\Layers;

use Symfony\Component\HttpFoundation\Request;
use Ozziest\Core\Data\IDB;

interface IMiddleware {
    
    public function exec(Request $request, IDB $db);
    
}