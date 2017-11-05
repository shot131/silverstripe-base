<?php
class GridFieldConfig_PageEditor extends GridFieldConfig {

    public function __construct($itemsPerPage=null) {
        parent::__construct();

        $button = new GridFieldAddNewSiteTreeItemButton('toolbar-header-right');
        $button->setButtonName('Добавить страницу');
        $this->addComponent(new GridFieldButtonRow('before'));
        //$this->addComponent(new GridFieldAddNewButton('buttons-before-left'));
        $this->addComponent($button);
        $this->addComponent(new GridFieldToolbarHeader());
        $this->addComponent($sort = new GridFieldSortableHeader());
        $this->addComponent($filter = new GridFieldFilterHeader());

        $columns = new GridFieldDataColumns();
        $columns->setDisplayFields(array(
            'Title' => 'Заголовок',
            'LastEdited' => 'Изменен',
            'Flags' => 'Статус'
        ));
        $this->addComponent($columns);
        //$this->addComponent(new GridFieldEditButton());
        //$this->addComponent(new GridFieldDeleteAction());
        $this->addComponent(new GridFieldPageCount('toolbar-header-right'));
        $this->addComponent($pagination = new GridFieldPaginator($itemsPerPage));
        //$this->addComponent(new GridFieldDetailForm());
        $this->addComponent(new GridFieldEditSiteTreeItemButton());

        $sort->setThrowExceptionOnBadDataType(false);
        $filter->setThrowExceptionOnBadDataType(false);
        $pagination->setThrowExceptionOnBadDataType(false);
    }
}