<?php

class DataListExtension extends Extension {

    public function IsSection() {
        foreach ($this->owner as $page) {
            if ($page instanceof SiteTree && $page->IsSection()) return true;
        }
        return false;
    }

}