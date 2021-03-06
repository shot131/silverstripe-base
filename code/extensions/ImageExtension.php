<?php

/**
 * Class ImageExtension
 * @property Image $owner
 */
class ImageExtension extends Extension {

    private $isDefault = false;

    public function onAfterUpload() {
        if ($this->owner->getWidth() > 1920 || $this->owner->getHeight() > 1080) {
            copy($this->owner->Fit(1920, 1080)->getFullPath(), $this->owner->getFullPath());
        }
        //$this->owner->Title = '';
        $this->owner->write();
    }

    public function PadMax($width, $height, $color = 'FFFFFF') {
        if (!$this->owner->exists()) {
            return $this->owner;
        }
        $srcWidth = $this->owner->getWidth();
        $srcHeight = $this->owner->getHeight();
        $wh = $height > 0 ? $width / $height : 0;
        $swh = $srcHeight > 0 ? $srcWidth / $srcHeight : 0;
        if ($wh > $swh) {
            $scalableWidth = false;
        } else {
            $scalableWidth = true;
        }
        $upSampling = ($scalableWidth && $width > $srcWidth) || (!$scalableWidth && $height > $srcHeight);
        if ($upSampling) {
            return $this->owner->Pad($width, $srcHeight, $color)->Pad($width, $height, $color);
        } else {
            return $this->owner->Pad($width, $height, $color);
        }
    }

    public function getIsDefault(): bool {
        return $this->isDefault;
    }

    public function setIsDefault($isDefault = false) {
        $this->isDefault = $isDefault;
        return $this->owner;
    }

}