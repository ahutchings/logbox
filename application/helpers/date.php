<?php

class date extends date_Core
{
    /**
     * retrieves a time difference in common vernacular
     *
     * @param int|string $time UNIX timestamp or parseable string
     *
     * @return string
     */
    public static function fuzzy_time($time = null)
    {
        $time      = ($time == null) ? time() : $time;
        $timestamp = (is_numeric($time)) ? $time : strtotime($time);
        $elapsed   = time() - $timestamp;

        switch ($elapsed) {
            case ($elapsed < -1209600):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 604800)) . ' week' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < -172800):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 86400)) . ' day' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < -7200):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 3600)) . ' hour' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < -120):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 60)) . ' minute' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < 0):
                return 'in ' . abs($elapsed) . ' second' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < 120):
                return $elapsed . ' second' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 7200):
                return ($elapsed = floor($elapsed / 60)) . ' minute' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 172800):
                return ($elapsed = floor($elapsed / 3600)) . ' hour' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 1209600):
                return ($elapsed = floor($elapsed / 86400)) . ' day' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 4838400):
                return ($elapsed = floor($elapsed / 604800)) . ' week' . (($elapsed == 1) ? '' : 's') . ' ago';
            default:
                return date('F d, Y', $timestamp);
        }
    }
}
