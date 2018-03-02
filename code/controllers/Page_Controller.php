<?php

/**
 * @property Page $dataRecord
 * Class Page_Controller
 */
class Page_Controller extends ContentController {

    protected $templates = [];

    public function init() {
        parent::init();
        $this->templates = SSViewer::get_templates_by_class(get_class($this->dataRecord), "", "SiteTree");
        if ($this->getField('Template')) array_unshift($this->templates, $this->getField('Template'));
        if (Director::is_ajax()) {
            array_unshift($this->templates, 'AjaxPage');
        }
        $this->extend('beforeInit');
        Requirements::css('assets/site/build/global.css');
        Requirements::javascript('assets/site/build/global.js');
        $this->extend('afterInit');
    }

    public function index() {
        if ($this->Template) array_unshift($this->templates, $this->Template);
        return $this->renderWith($this->templates);
    }

    public function PaginatedOf($method, $pageLength) {
        if ($this->hasMethod($method)) {
            return UniPaginatedList::create(
                $this->{$method}(),
                $this->request
            )->setPageLength($pageLength);
        } else if ($this->dataRecord->hasMethod($method)) {
            return UniPaginatedList::create(
                $this->dataRecord->{$method}(),
                $this->request
            )->setPageLength($pageLength);
        }
    }

}
