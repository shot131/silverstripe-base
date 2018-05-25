<?php

class GalleryExtension extends DataExtension {

    private static $many_many = [
        'Images' => 'Image'
    ];

    private static $many_many_extraFields = array(
        'Images' => [
            'SortOrder' => 'Int'
        ]
    );

    public function onBeforeDelete() {
        parent::onBeforeDelete();

        $stage = Versioned::current_stage();
        if($this->owner->isInDB() && $stage === 'Stage') {
            $this->owner->Images()->removeAll();
        }
    }

    public function updateCMSFields(FieldList $fields) {
        $fields->findOrMakeTab('Root.Gallery', _t('Image.PLURALNAME', 'Gallery'));
        $imageField = new SortableUploadField('Images', _t('Image.PLURALNAME', 'Gallery'));
        $imageField->setFolderName('Gallery');
        $imageField->getValidator()->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $fields->addFieldToTab('Root.Gallery', $imageField);
    }

    public function getGallery() {
        if ($this->owner->Images()->exists()) return $this->owner->Images()->sort('SortOrder', 'ASC');
        else return new ArrayList([SiteConfig::current_site_config()->getNoImage()]);
    }

    public function HasGallery() {
        return $this->owner->Images()->exists();
    }

    public function getImage() {
        return $this->getGallery()->First();
    }

    public function getCMSImage() {
        return $this->getImage()->ScaleWidth(100);
    }

}