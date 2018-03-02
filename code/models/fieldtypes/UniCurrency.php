<?php

class UniCurrency extends DBFloat {

    public function Nice() {
        $val = number_format(
            abs($this->value),
            0,
            ',',
            ' '
        );
        return $val;
    }

    public function WithSymbol() {
        return $this->Nice() . ' ' . $this->config()->currency_symbol;
    }

    public function forTemplate() {
        return $this->Nice();
    }

}