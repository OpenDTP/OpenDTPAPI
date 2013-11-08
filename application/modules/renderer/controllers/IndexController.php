<?php

class Renderer_IndexController extends ODTPFramwork_Controller
{

  public function indexAction()
  {
  	$query = new ODTPFramwork_Renderer_Query('RENDER test.sla, test2.sla OUTPUT test.pdf, test2.pdf');
    $documentManager = new ODTPFramwork_Renderer_Document_Manager($query->getInput());

  	// getting a renderer
  	$this->view->debug = (string)$query;
  }

}

