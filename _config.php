<?php

if(class_exists('Imagick')){Image::set_backend('ImagickBackend');}

Injector::inst()->registerService(new SmtpMailer(), 'Mailer');

HtmlEditorConfig::get('cms')->setOption('content_css', "base/css/editor.css");

// Set the site locale
i18n::set_locale('ru_RU');

// Cache all pages to 24 hours
HTTP::set_cache_age(86400);

if (Director::isDev()) {
	error_reporting(-1);
}

ShortcodeParser::get('default')->register('site_url', function($arguments, $content = null, $parser = null, $tagName) {
    return Director::absoluteBaseURL();
});
ShortcodeParser::get('default')->register('site_config', function($arguments, $content = null, $parser = null, $tagName) {
    if (isset($arguments['field'])) {
        return SiteConfig::current_site_config()->getField($arguments['field']);
    }
});

require_once('conf/ConfigureFromEnv.php');
global $_SMTP_CONFIG;
Config::inst()->update('SmtpMailer', 'host', $_SMTP_CONFIG['host']);
Config::inst()->update('SmtpMailer', 'user', $_SMTP_CONFIG['user']);
Config::inst()->update('SmtpMailer', 'password', $_SMTP_CONFIG['password']);
Config::inst()->update('SmtpMailer', 'encryption', $_SMTP_CONFIG['encryption']);
Config::inst()->update('SmtpMailer', 'charset', $_SMTP_CONFIG['charset']);
Config::inst()->update('SmtpMailer', 'from', $_SMTP_CONFIG['from']);
Config::inst()->update('SmtpMailer', 'to', $_SMTP_CONFIG['to']);
Config::inst()->update('SmtpMailer', 'port', 465);
Injector::inst()->registerService(new SmtpMailer(), 'Mailer');