<?php

class UniTemplateGlobalProvider implements TemplateGlobalProvider {

    public static function ProjectDir() {
        global $project;
        return $project;
    }

    public static function CurrentTime() {
        return SS_Datetime::now();
    }

    public static function PageByID($id) {
        return Page::get()->byID($id);
    }

    public static function Showcase($count = 10) {
        $tours = TourPage::get()->filter('Bestseller', true)->limit(10)->toArray();
        if (count($tours) < $count) {
            $tours = array_merge($tours, TourPage::get()->filter('Bestseller', false)->limit($count - count($tours))->toArray());
        }
        return new ArrayList($tours);
    }

    public static function FormatFileSize($size) {
        return File::format_size($size);
    }

    public static function get_template_global_variables() {
        return ['ProjectDir', 'CurrentTime', 'EmplIntervalsJSON', 'OperIntervalsJSON', 'EmplIncreaseJSON', 'CalcPricesJSON', 'ZeroPricesJSON', 'PageByID', 'Showcase', 'FormatFileSize'];
    }

}