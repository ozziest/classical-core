<?php namespace Ozziest\Core\Helpers;

use DateTime, DateInterval;

class DateHelper {
    
    /**
     * This method creates a new date with additions
     * 
     * @param  string   $period
     * @return string
     */
    public static function getExpiredDate($period = 'PT30M')
    {
        $now = new DateTime();
        $now = $now->add(new DateInterval($period));
        return $now->format('Y-m-d H:i:s');
    }
    
}