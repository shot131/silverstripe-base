<?php

class CMSTreeParent extends Extension {

    protected $hiddenChildren = array();

    public function updateCMSFields(FieldList &$fields) {
        $childClass = Config::inst()->get($this->ownerBaseClass, 'hide_from_hierarchy');
        $fields->findOrMakeTab('Root.Children', _t($childClass.'.PLURALNAME', 'Children'));
        $fields->addFieldToTab('Root.Children', GridField::create(
            'Children',
            _t($childClass.'.PLURALNAME', 'Children'),
            $childClass::get()->filter('ParentID', $this->owner->ID),
            GridFieldConfig_PageEditor::create()
        ));
    }

    public function CMSTreeChildren() {
        $childClass = Config::inst()->get($this->ownerBaseClass, 'hide_from_hierarchy');
        $children = $childClass::get()->filter([
            'ParentID' => $this->owner->ID,
            'ShowInMenus' => true
        ])->sort('Created', 'DESC');
        return $children;
    }

    public function RecursiveCMSTreeChildren() {
        $childClass = Config::inst()->get($this->ownerBaseClass, 'hide_from_hierarchy');
        $groupids = array($this->owner->ID);
        $groupids += $this->getAllChildCategoryIDs();
        $children = $childClass::get()->filter([
            'ParentID' => $groupids,
            'ShowInMenus' => true
        ])->sort('Created', 'DESC');
        return $children;
    }

    public function getAllChildCategoryIDs() {
        $ids = array($this->owner->ID);
        $allids = array();
        $class = $this->ownerBaseClass;
        do {
            $ids = $class::get()
                ->filter('ParentID', $ids)
                ->getIDList();
            $allids += $ids;
        } while (!empty($ids));

        return $allids;
    }

}