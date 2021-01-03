<?php

namespace Angorb\BetaflightProfiler\Models;

use Angorb\BetaflightProfiler\Traits\Savable;

class VTX
{
    use Savable;

    const MIN_FREQUENCY = 0;
    const MAX_FREQUENCY = 1;

    private $bands_list;
    private $powerlevels_list;

    public function setBand(
        int $id,
        string $name,
        string $letter,
        string $is_factory_band,
        array $frequencies
    ) {
        $this->bands_list[$id] = [
            'name' => $name,
            'letter' => $letter,
            'is_factory_band' => $is_factory_band,
            'frequencies' => $frequencies,
        ];
    }

    public function setPower(int $id, string $name, string $value)
    {
        $this->powerlevels_list[$id][$name] = $value;
    }

    public function findMinFrequency(bool $frequencyOnly = \false)
    {
        return $this->findEdgeFrequency(self::MIN_FREQUENCY, $frequencyOnly);
    }

    public function findMaxFrequency(bool $frequencyOnly = \false)
    {
        return $this->findEdgeFrequency(self::MAX_FREQUENCY, $frequencyOnly);
    }

    public function getChannelTable(bool $returnChannelWidth = \false)
    {
        $val = [];
        foreach ($this->bands_list as $band) {
            $name = $band['name'];
            foreach ($band['frequencies'] as $index => $frequency) {
                if (empty($frequency)) {
                    continue;
                }
                $channel = \sprintf("%s %s", $name, ($index + 1));
                $val[$channel] = ($returnChannelWidth) ? $this->getChannelWidth($frequency) : $frequency;
            }
        }
        \asort($val);
        return $val;
    }

    private function findEdgeFrequency(int $mode, bool $frequencyOnly)
    {
        $val = [
            'band' => null,
            'channel' => null,
            'frequency' => null,
        ];

        foreach ($this->bands_list as $band) {
            $name = $band['name'];
            foreach ($band['frequencies'] as $index => $frequency) {
                // skip frequencies locked out / not in use
                if ($frequency == 0) {
                    continue;
                }

                switch ($mode) {
                    case self::MIN_FREQUENCY:$comparison = $frequency < $val['frequency'];
                        break;
                    case self::MAX_FREQUENCY:$comparison = $frequency > $val['frequency'];
                        break;
                }

                if ($comparison || \is_null($val['frequency'])) {
                    $val = [
                        'band' => $name,
                        'channel' => $index + 1,
                        'frequency' => $frequency,
                    ];
                }
            }
        }

        if ($frequencyOnly) {
            return (int) $val['frequency'];
        }

        return $val;
    }

    public function getChannelWidth(int $frequency)
    {
        return [
            'low' => $frequency - 150,
            'center' => $frequency,
            'high' => $frequency + 150,
        ];
    }

    public function findUnusedChannels()
    {
        $val = [];
        foreach ($this->bands_list as $band) {
            $name = $band['name'];
            foreach ($band['frequencies'] as $index => $frequency) {
                if (empty($frequency)) {
                    $val[] = [
                        'band' => $name,
                        'channel' => $index + 1,
                    ];
                }
            }
        }

        return $val;
    }

    public function set()
    {
        return !(empty($this->bands_list));
    }
}