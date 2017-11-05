<?php
class VarcharExtension extends Extension {

    function Decode() {
        return html_entity_decode($this->owner->Value);
    }

    function Clean() {
        return strip_tags(preg_replace([
            "/<br>/i",
            "/&nbsp;/i",
            "/&#?[a-z0-9]+;/i"
        ], [' ', ' ', ''], $this->owner->Value));
    }

    function Ucfirst() {
        return Helpers::mb_ucfirst($this->owner->Value);
    }

}