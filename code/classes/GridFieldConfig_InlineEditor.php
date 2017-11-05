<?php
class GridFieldConfig_InlineEditor extends GridFieldConfig {
    public function __construct($fields = null) {
        parent::__construct();
        $button = new GridFieldAddNewInlineButton();
        $cols = new GridFieldEditableColumns();
        if ($fields) {
            $cols->setDisplayFields($fields);
        }
        $this->addComponent($button->setTitle('Добавить'));
        $this->addComponent(new GridFieldButtonRow('before'));
        $this->addComponent(new GridFieldToolbarHeader());
        $this->addComponent($cols);
        $this->addComponent(new GridFieldTitleHeader());
        $this->addComponent(new GridFieldDeleteAction());
    }
}