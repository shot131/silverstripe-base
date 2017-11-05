<?php

class ListRandomExtension extends Extension {

    private $array;

    private function getArray() {
        if (!$this->array) {
            $this->array = array_values($this->owner->toArray());
        }
        return $this->array;
    }

    /**
     * @return DataObject
     */
    public function getRandomOne() {
        $array = $this->getArray();
        return $array[array_rand($array, 1)];
    }

    /**
     * @param int $min
     * @param int $max
     * @return ArrayList
     */
    public function getRandomMany($min, $max = 0) {
        $array = $this->getArray();
        if (!$max) {
            $count = $min;
        } else {
            $count = mt_rand($min, $max);
        }
        $result = new ArrayList([]);
        if ($count) {
            $keys = array_rand($array, $count);
            if (!is_array($keys)) {
                $result->push($array[$keys]);
            } else {
                foreach ($keys as $key) {
                    $result->push($array[$key]);
                }
            }
        }
        return $result;
    }

}