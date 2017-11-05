<?php

class TextExtension extends Extension {

    public function DecodedSummary($maxWords) {
        return html_entity_decode($this->owner->Summary($maxWords));
    }

}