<?php

class FileExtension extends DataExtension {

    private static $db = [
        'RemoteName' => 'Varchar(255)'
    ];

    public function getSizeRu() {
        $size = $this->owner->getAbsoluteSize();

        if($size < 1024) return $size . ' Байт';
        if($size < 1024*10) return (round($size/1024*10)/10). ' Кб';
        if($size < 1024*1024) return round($size/1024) . ' Кб';
        if($size < 1024*1024*10) return (round(($size/1024)/1024*10)/10) . ' Мб';
        if($size < 1024*1024*1024) return round(($size/1024)/1024) . ' Мб';

        return $size;
    }

    public function UppercaseExtension() {
        return mb_strtoupper($this->owner->getExtension());
    }

}