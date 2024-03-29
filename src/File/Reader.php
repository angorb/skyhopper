<?php

namespace Angorb\BetaflightProfiler\File;

use Angorb\BetaflightProfiler\File\FileAttributes;
use Angorb\BetaflightProfiler\Models\Profile;
use Angorb\BetaflightProfiler\Models\VtxProfile;

class Reader
{
    private $section;
    private $profileId;
    private $profile;
    private $vtx;

    private function __construct(string $file)
    {
        $this->profile = new Profile();
        $this->vtx = new VtxProfile();

        if (!\file_exists($file)) {
            throw new \Exception('Could not open file: ' . $file);
        }

        if ($inFile = \fopen($file, 'r')) {
            // TODO could not open file
        }

        while ($line = fgets($inFile)) {
            if (!empty(\trim($line))) {
                $this->parseLine(\trim($line));
            }
        }

        return $this;
    }

    public static function fromFile($file)
    {
        $reader = new Reader($file);
        // add VTX table
        if (!empty($reader->vtx)) {
            $reader->profile->setVtxProfile($reader->vtx);
        }
        return $reader->profile;
    }

    private function parseLine($line)
    {
        $data = \preg_split('/\s+/', $line);
        $id = \array_shift($data);

        switch ($id) {
            case '#':
                $this->parseHeading($data);
                break;
            case 'board_name':
                $this->profile->setBoardName($data[0]);
                break;
            case 'manufacturer_id':
                $this->profile->setManufacturerId($data[0]);
                break;
            case 'mcu_id':
                $this->profile->setMcuId($data[0]);
                break;
            case 'profile':
            case 'rateprofile':
                $this->profileId = $data[0];
                break;
            case 'set':
                $this->setProperty($data);
                break;
            case 'vtxtable':
                $this->parseVTX($data);
                break;
            default:
                echo 'Discarded ' . $line . \PHP_EOL; // DEBUG
        }
    }

    private function parseVTX(array $data)
    {
        $lineType = \array_shift($data);

        if ($lineType === 'band') {
            $id = \array_shift($data);
            $name = \array_shift($data);
            $letter = \array_shift($data);
            $is_factory_band = ('FACTORY' === \array_shift($data)) ? "true" : "false";
            $this->vtx->setBand(
                $id,
                $name,
                $letter,
                $is_factory_band,
                $data
            );
        }

        if ($lineType === 'powervalues' || $lineType === 'powerlabels') {
            $name = \substr(\str_replace('power', '', $lineType), 0, -1);
            foreach ($data as $id => $value) {
                $this->vtx->setPower($id, $name, $value);
            }
        }
    }

    private function parseHeading(array $data)
    {
        if (empty($data)) {
            return;
        }

        $section = \array_shift($data);

        if ($section === 'name:') {
            $this->profile->setCraftName(\implode(" ", $data));
        }

        $this->section = $section;

        if (!empty($this->profileId) && !\in_array($section, FileAttributes::$indexedProfiles)) {
            unset($this->profileId);
        }
    }

    private function setProperty(array $data)
    {
        $section = $this->section;
        $name = $data[0];
        $value = $data[2];

        if (\stristr($data[2], ',')) {
            $value = \explode(',', $data[2]);
        }

        if (\count($data) > 3) {
            $value = \implode(" ", \array_slice($data, 2));
        }

        if ($section === FileAttributes::$masterPropertyName) {
            $this->profile->setMasterProperty($name, $value);
            return;
        }

        if (\in_array($section, FileAttributes::$indexedProfiles) && isset($this->profileId)) {
            $this->profile->setProfileProperty(
                $this->section,
                $this->profileId,
                $name,
                $value
            );
            return;
        }
    }
}
