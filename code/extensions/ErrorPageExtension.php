<?php

class ErrorPage_ControllerExtension extends Extension {

    public function afterInit() {
        Requirements::clear('assets/site/build/global.js');
    }

}