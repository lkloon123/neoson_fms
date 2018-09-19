<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


class HashrateHelper
{
    public static function convert($hashrate)
    {
        if ($hashrate > 1000000000000000) {
            return round($hashrate / 1000000000000000, 3) . ' PH/s';
        }

        if ($hashrate > 1000000000000) {
            return round($hashrate / 1000000000000, 3) . ' TH/s';
        }

        if ($hashrate > 1000000000) {
            return round($hashrate / 1000000000, 3) . ' GH/s';
        }

        if ($hashrate > 1000000) {
            return round($hashrate / 1000000, 3) . ' MH/s';
        }

        if ($hashrate > 1000) {
            return round($hashrate / 1000, 3) . ' KH/s';
        }

        return $hashrate . ' H/s';
    }
}