<?php

class ColumnizedExtension extends Extension {

    public function ColumnizedOf($method, $colsNum = null, $threshold = null) {
        if ($this->owner->hasMethod($method)) {
            return new ColumnizedList ($this->owner->{$method}(), $colsNum, $threshold);
        }
        return null;
    }

}