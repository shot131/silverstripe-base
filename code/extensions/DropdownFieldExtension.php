<?php

class DropdownFieldExtension extends Extension {

    private $optionsExtras = [];

    private $options;

    public function addOptionsExtra($name, $val) {
        $this->optionsExtras[$name] = $val;
    }

    public function getOptions() {
        if (!$this->options) $this->owner->Field();
        return $this->options;
    }

    public function onBeforeRender(&$field) {
        $options = $field->getCustomisedObj()->Options;
        foreach ($this->optionsExtras as $name => $val) {
            foreach ($options as &$option) {
                if (isset($val[$option->Value]))
                    $option->setField($name, $val[$option->Value]);
            }
        }
        $this->options = $options;
        $field->customise(['Options' => $options]);
    }

}