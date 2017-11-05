<?php

class CMSTreeChild extends Extension {

    private static $summary_fields = [
        'Title' => 'Заголовок',
        'LastEdited' => 'Изменен',
        'Flags' => 'Статус'
    ];

    public function getFlags() {
        return implode(', ', array_map(function ($flag) {
            return $flag['text'];
        }, $this->owner->getStatusFlags()));
    }

}