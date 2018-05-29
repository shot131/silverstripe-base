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

    public function updateCMSFields(FieldList $fields) {
        $fields->findOrMakeTab('Root.Gallery', _t('Image.PLURALNAME', 'Gallery'));
        $imageField = new SortableUploadField('Images', _t('Image.PLURALNAME', 'Gallery'));
        $imageField->setFolderName('Gallery');
        $imageField->getValidator()->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $fields->addFieldToTab('Root.Gallery', $imageField);
    }

    public function getGallery() {
        $result = new ArrayList;
        if ($this->owner->Images()->exists()) {
            $images = $this->owner->Images()->sort('SortOrder', 'ASC');
            foreach ($images as $image) {
                if ($image->exists()) {
                    $result->push($image);
                }
            }
        }
        if (!$result->count()) {
            $result = new ArrayList([SiteConfig::current_site_config()->getNoImage()]);
        }
        return $result;
    }

    public function HasGallery() {
        return $this->owner->Images()->exists();
    }

    public function getImage() {
        $image = $this->getGallery()->First();
        if ($image->exists()) {
            $result = $image;
        } else {
            $result = SiteConfig::current_site_config()->getNoImage();
        }
        return $result;
    }

    public function getCMSImage() {
        return $this->getImage()->ScaleWidth(100);
    }

}