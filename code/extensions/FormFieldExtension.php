<?php

class FormFieldExtension extends Extension {

    private $extras = [];

    public function addExtra($name, $val) {
        $this->extras[$name] = $val;
        return $this->owner;
    }

    public function getExtra($name) {
        return $this->extras[$name];
    }

    public function Extra($name) {
        return $this->getExtra($name);
    }

}