<?php

namespace Angorb\BetaflightProfiler\Models;

use Angorb\BetaflightProfiler\File\FileAttributes;
use JsonSerializable;

class Profile implements JsonSerializable
{
    # board information
    protected $board_name;
    protected $manufacturer_id;
    protected $mcu_id;

    #properties
    protected $master;
    protected $vtx;

    public function jsonSerialize(): mixed
    {
        $profile = [
            'board_name' => $this->board_name,
            'manufacturer_id' => $this->manufacturer_id,
            'mcu_id' => $this->mcu_id,
            'master' => $this->master,
        ];

        // add rates & profiles
        foreach (FileAttributes::$indexedProfiles as $indexedProfile) {
            if (isset($this->$indexedProfile)) {
                $profile += [
                    $indexedProfile => $this->$indexedProfile
                ];
            }
        }

        if (isset($this->vtx)) {
            $profile += [
                'vtx' => $this->vtx
            ];
        }

        return $profile;
    }

    public function setMasterProperty($name, $value)
    {
        $propertyName = FileAttributes::$masterPropertyName;
        $this->$propertyName[$name] = $value;
    }
    public function setProfileProperty(string $profile, int $id, string $name, $value)
    {
        $this->$profile[$id][$name] = $value;
    }

    public function getProfileCount(string $profile)
    {
        return \count($this->$profile ?? []);
    }

    /* CRAFT FEATURES */

    public function setBoardName(string $name)
    {
        $this->board_name = $name;
    }

    public function getBoardName(): ?string
    {
        return $this->board_name;
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

    public function getCraftName()
    {
        return $this->name ?? null;
    }

    public function setVTX(VTX $vtx)
    {
        $this->vtx = $vtx;
    }

    public function hasVTX(): bool
    {
        return !empty($this->vtx);
    }
}
