<?php

class TemporaryPage extends Page {

    public function Menu($level) {
        $controller = Controller::curr();
        if ($controller instanceof Page_Controller) {
            return $controller->getMenu($level);
        }
        return '';
    }

}