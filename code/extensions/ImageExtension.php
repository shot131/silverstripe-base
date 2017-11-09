<?php

class ImageExtension extends Extension {

    public function onAfterUpload() {
        if ($this->owner->getWidth() > 1920 || $this->owner->getHeight() > 1080) {
            copy($this->owner->Fit(1920, 1080)->getFullPath(), $this->owner->getFullPath());
        }
        $this->owner->Title = '';
        $this->owner->write();
    }

    public function PadMax($width, $height, $color = 'FFFFFF') {
        $srcWidth = $this->owner->getWidth();
        $srcHeight = $this->owner->getHeight();
        if ($width / $height > $srcWidth / $srcHeight) {
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

}