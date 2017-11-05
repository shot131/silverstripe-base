<?php

class ErrorPage_ControllerExtension extends Extension {

    public function afterInit() {
        global $project;
        Requirements::clear($project.'/assets/build/global.js');
    }

}