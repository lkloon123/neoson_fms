<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


use Cache;
use Github;

class VersioningHelper
{
    private static $key;
    private static $repo;

    public static function mainApp()
    {
        self::$key = 'main_version';
        self::$repo = 'neoson_fms';
        return new static;
    }

    public static function minerControl()
    {
        self::$key = 'miner_control_version';
        self::$repo = 'neoson_fms_miner';
        return new static;
    }

    public static function ver()
    {
        return Cache::remember(self::$key, config('cache.duration'),
            function () {
                return Github::repo()
                    ->releases()
                    ->latest('lkloon123', self::$repo)['tag_name'];
            });
    }

    public static function verNumber()
    {
        return substr(self::ver(), 1);
    }
}