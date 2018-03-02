<?php

class File_Cached extends File {

    public function __construct($filename = null, $isSingleton = false, File $sourceFile = null) {
        parent::__construct(array(), $isSingleton);
        if ($sourceFile) {
            // Copy properties from source file, except unsafe ones
            $properties = $sourceFile->toMap();
            unset($properties['RecordClassName'], $properties['ClassName']);
            $this->update($properties);
        }
        $this->ID = -1;
        $this->Filename = $filename;
    }

    public function exists()
    {
        return file_exists($this->getFullPath());
    }

    public function getRelativePath()
    {
        return $this->getField('Filename');
    }

    public function requireTable() {
        return false;
    }

    public function write($showDebug = false, $forceInsert = false, $forceWrite = false, $writeComponents = false)
    {
        throw new Exception("{$this->ClassName} can not be written back to the database.");
    }

}