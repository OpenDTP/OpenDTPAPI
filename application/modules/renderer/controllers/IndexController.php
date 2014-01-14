<?php

class Renderer_IndexController extends ODTPFramwork_Controller
{

    public function indexAction() {
    	$manager = Zend_Registry::get('RendererManager');
      $query = new ODTPFramwork_Renderer_Query('RENDER C:/Users/mforaste/Desktop/Document-1.sla OUTPUT test1.pdf');
      $responses = $manager->query($query);

      $this->view->query = (string)$query;
      $this->view->response = $responses[0]->getResponse();
    }

}

