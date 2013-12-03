<?php

class Renderer_IndexController extends ODTPFramwork_Controller
{

  public function indexAction()
  {
  	$query = new ODTPFramwork_Renderer_Query('RENDER C:/Users/mforaste/Desktop/Document-1.sla OUTPUT test.pdf, test2.pdf');

  	// getting a renderer
  	$this->view->debug = (string)$query;
  }

}

