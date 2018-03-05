<?php

/**
 * Class UniSiteConfigExtension
 * @property SiteConfig $owner
 */
class UniSiteConfigExtension extends DataExtension {

    private static $db = array (
        'Address' => 'Varchar(255)',
        'Schedule' => 'Varchar(255)',
        'Phone1' => 'PhoneNumber',
        'Phone2' => 'PhoneNumber',
        'Email' => 'Varchar(255)',
        'Footer' => 'HTMLText',
        'Robots' => 'Text'
    );

    private static $has_one = [
        'DBNoImage' => 'Image',
        'DBNoPhoto' => 'Image',
        'PrivacyPage' => 'Page'
    ];
    
    public function getNoImage(): Image {
        /** @var Image $image */
        $image = $this->owner->getComponent('DBNoImage')->setIsDefault(true);
        return $image;
    }

    public function getNoPhoto() {
        /** @var Image $image */
        $image = $this->owner->getComponent('DBNoPhoto')->setIsDefault(true);
        return $image;
    }

    public function updateCMSFields(FieldList $fields) {
        $fields->removeByName('Tagline');
        $fields->removeByName('Theme');
        $fields->addFieldsToTab('Root.Main', array (
            TextField::create('Schedule', _t('SiteConfig.Schedule', 'Schedule')),
            TextField::create('Address', _t('SiteConfig.Address', 'Address')),
            TextField::create('Phone1', _t('SiteConfig.Phone', 'Phone')),
            TextField::create('Phone2', _t('SiteConfig.Phone', 'Phone')),
            EmailField::create('Email', _t('SiteConfig.Email', 'Email'))
        ));

        $fields->findOrMakeTab('Root.SEO', _t('SiteConfig.CMSTabs.SEO', 'SEO'));
        $fields->addFieldsToTab('Root.SEO', [
            $codeField = new CodeEditorField('Footer', _t('SiteConfig.Footer', 'Footer code')),
            TextareaField::create('Robots','robots.txt')
        ]);
        $codeField->addExtraClass('stacked');
        $codeField->setTheme($codeField->getLightTheme());
        $codeField->setRows(20);

        $exclude = SiteConfig::config()->exclude_fields;
        foreach (array_keys(self::$db) as $key) {
            if ($exclude && in_array($key, $exclude)) {
                $fields->removeByName($key);
            }
        }

        $fields->findOrMakeTab('Root.Placeholders', _t('SiteConfig.CMSTabs.Placeholders', 'Placeholders'));
        $fields->addFieldsToTab('Root.Placeholders', [
            $uploader1 = UploadField::create('DBNoImage', _t('SiteConfig.db_NoImage', 'NoImage')),
            $uploader2 = UploadField::create('DBNoPhoto', _t('SiteConfig.db_NoPhoto', 'NoPhoto')),
            TreeDropdownField::create('PrivacyPageID', _t('SiteConfig.db_PrivacyPage', 'PrivacyPage'), 'SiteTree')
        ]);
        $uploader1->getValidator()->setAllowedExtensions(['jpg', 'png', 'jpeg']);
        $uploader2->getValidator()->setAllowedExtensions(['jpg', 'png', 'jpeg']);
    }

}