<?php

class PhoneNumber extends Varchar {

    public function Raw() {
        return preg_replace('/[^0-9\+]/', '', $this->Value);
    }

    public function forTemplate() {
        return $this->Value;
    }

}