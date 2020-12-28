<?php

namespace Angorb\BetaflightProfiler\Traits;

trait Savable
{
    public function json()
    {
        $data = \get_object_vars($this);
        ksort($data);
        return \json_encode($data, \JSON_PRETTY_PRINT);
    }
}