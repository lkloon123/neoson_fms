<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


class MinerConfigGeneratorHelper
{
    public static function ccMinerConfig($algoName, $poolStratumWithPort, $walletAddress, $coinTicker)
    {
        return '-a ' . $algoName .
            ' -o stratum+tcp://' . $poolStratumWithPort .
            ' -u ' . $walletAddress .
            ' -p c=' . $coinTicker;
    }

    public static function claymoreMinerConfig($poolStratumWithPort, $walletAddress)
    {
        return '-epool ' . $poolStratumWithPort .
            ' -ewal ' . $walletAddress .
            ' -epsw x';
    }
}