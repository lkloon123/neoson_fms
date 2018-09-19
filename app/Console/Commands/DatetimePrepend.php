<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Console\Commands;


use Carbon\Carbon;

class DatetimePrepend
{
    public static function getDateTime()
    {
        return '[' . Carbon::now()->format(config('app.datetime_format')) . '] ';
    }
}