<?php

class IndexController extends ODTPFramwork_Controller {

    public function indexAction() {
        $this->view->alive = 1;
        $this->view->version = API_VERSION;
    }

}

