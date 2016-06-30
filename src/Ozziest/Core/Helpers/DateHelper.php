<?php namespace Ozziest\Core\Helpers;

use DateTime, DateInterval, Lang;

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

    public static function justDate($date)
    {
        return substr($date, 0, 10);
    }

    public static function toHuman($date)
    {
        $date = new DateTime($date);
        $ptime = $date->getTimestamp();

        $etime = time() - $ptime;

        if ($etime < 1)
        {
            return '0 '.Lang::get('seconds');
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
                     30 * 24 * 60 * 60  =>  'month',
                          24 * 60 * 60  =>  'day',
                               60 * 60  =>  'hour',
                                    60  =>  'minute',
                                     1  =>  'second'
                    );
        $a_plural = array( 'year'   => 'years',
                           'month'  => 'months',
                           'day'    => 'days',
                           'hour'   => 'hours',
                           'minute' => 'minutes',
                           'second' => 'seconds'
                    );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? Lang::get($a_plural[$str]) : Lang::get($str)) . ' '.Lang::get('ago');
            }
        }
    }

}
