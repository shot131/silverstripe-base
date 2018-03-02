<?php

class DecimalField extends NumericField
{

    protected function clean($input)
    {
        return parent::clean(str_replace('.', ',', $input));
    }

    public function getLocale()
    {
        return 'ru_RU';
    }

    public function setValue($value, $data = array())
    {
        if (isset($value)) {
            return parent::setValue($value, $data);
        } else {
            return $this;
        }
    }

}