<?php

namespace Angorb\BetaflightProfiler\Traits;

trait Savable
{
    public function json()
    {
        $data = \get_object_vars($this);
        foreach ($data as $key => $value) {
            if (\is_object($value)) {
                if (\method_exists($value, 'json')) {
                    $data[$key] = \json_decode($value->json(), \true);
                } else {
                    $data[$key] = \json_decode(\json_encode($value), \true);
                }
            }

        }
        ksort($data);
        return \json_encode($data, \JSON_PRETTY_PRINT);
    }
}