<?php

class TextController extends ODTPFramwork_Controller {

  public function indexAction() {
  }

  public function postAction() {

    $text = $this->getRequest()->getParam('text');
    $file = $this->getRequest()->getParam('doc');

    if (!$text) {
      $this->view->error_code = 1;
      $this->view->error_message = 'Missing text param';
    }

    if (!$file) {
      $this->view->error_code = 1;
      $this->view->error_message = 'Missing doc param';
    }

    $client = new Zend_Http_Client();
    $client->setUri('http://82.244.76.215/setText.py/' . $file . '/' . urlencode($text));
    $client->request();

    $this->view->error_code = 0;
    $this->view->error_message = 'Success !';

  }

  public function getAction() {

  }

}
