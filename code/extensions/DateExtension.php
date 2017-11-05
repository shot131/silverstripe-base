<?php

class DateExtension extends Extension {

    public function NiceRU() {
        return $this->owner->Format(_t('Date.DateFormatNice', ['month' => _t('Date.Months.'.$this->owner->Format('n'))]));
    }

}