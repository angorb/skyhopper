<?php

namespace Angorb\BetaflightProfiler\Models;

use Angorb\BetaflightProfiler\Settings;
use Angorb\BetaflightProfiler\Traits\Savable;

class Profile
{
    use Savable;
    # board information
    protected $board_name;
    protected $manufacturer_id;
    protected $mcu_id;

    #properties
    protected $master;

    public function setBoardName(string $name)
    {
        $this->board_name = $name;
    }

    public function setManufacturerId(string $id)
    {
        $this->manufacturer_id = $id;
    }

    public function setMcuId(string $id)
    {
        $this->mcu_id = $id;
    }

    public function setCraftName(string $name)
    {
        $this->name = $name;
    }

    public function setMasterProperty($name, $value)
    {
        $propertyName = Settings::$masterPropertyName;
        $this->$propertyName[$name] = $value;
    }
    public function setProfileProperty(string $profile, int $id, string $name, $value)
    {
        $this->$profile[$id][$name] = $value;
    }

    public function setVtxTable(VideoTransmitterTable $vtxtable)
    {
        $this->vtxtable = $vtxtable;
    }
}