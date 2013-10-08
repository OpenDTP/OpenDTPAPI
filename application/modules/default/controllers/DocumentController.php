<?php

class DocumentController extends ODTPFramwork_Controller {

  public function indexAction() {
  }

  public function postAction() {

    $uploads_dir = '/tmp';
    $tmp_name = $_FILES["doc"]["tmp_name"];
    $name = $_FILES["doc"]["name"];
    $file_md5 = md5_file($uploads_dir . "/" . $tmp_name);
    file_put_contents($name . ".md5", $file_md5);
    move_uploaded_file($tmp_name, $uploads_dir . "/" . $name);
    $error = 0;
    $this->view->md5 = $file_md5;
    $this->view->error_code = $error;
    $this->view->error_message = "It's working !";

  }

  public function getAction() {

  }

}
