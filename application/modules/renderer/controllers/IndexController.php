<?php

class Renderer_IndexController extends ODTPFramwork_Controller
{

  public function indexAction()
  {
  	$query = new ODTPFramwork_Renderer_Query('RENDER C:/Users/mforaste/Pictures/JUMP_couverture_Van_Halen.jpg OUTPUT test.pdf, test2.pdf');
    $documentManager = new ODTPFramwork_Renderer_Document_Manager($query->getInput());

  	// getting a renderer
  	$this->view->debug = (string)$query;
  }

}

