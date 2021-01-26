<?php

namespace Angorb\BetaflightProfiler\Calculators;

class Rate
{
    // converted from:
    // https://github.com/apocolipse/RotorPirates/blob/master/RotorPirates.py
    public function getBetaflightRates($rcCommand, $rcRate, $expo, $superRate)
    {
        $absRcCommand = \abs($rcCommand);

        if ($rcRate > 2) {
            $rcRate = $rcRate + (14.54 * ($rcRate - 2));
        }

        if ($expo !== 0) {
            $rcCommand = $rcCommand * \abs($rcCommand) ** 3 * $expo + $rcCommand * (1 - $expo);
        }

        $angleRate = 200 * $rcRate * $rcCommand;
        if ($superRate !== 0) {
            $rcSuperFactor = 1 / (self::clamp(1 - ($absRcCommand * ($superRate)), 0.01, 1));
            $angleRate *= $rcSuperFactor;
        }
        return $angleRate;
    }

    private static function clamp($n, $minN, $maxN)
    {
        return \max(\min($maxN, $n), $minN);
    }
}