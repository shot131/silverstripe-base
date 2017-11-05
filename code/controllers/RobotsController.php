<?php
class RobotsController extends Controller {

    private static $allowed_actions = ['index'];

    public function index() {
        $this->response->addHeader('Content-Type', 'text/plain');
        return SiteConfig::current_site_config()->Robots;
    }

}