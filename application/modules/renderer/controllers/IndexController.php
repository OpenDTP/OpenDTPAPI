<?php

class Renderer_IndexController extends ODTPFramwork_Controller
{

    public function indexAction() {
    	$manager = Zend_Registry::get('RendererManager');
      $query = new ODTPFramwork_Renderer_Query('RENDER C:/Users/mforaste/Desktop/Document-1.sla OUTPUT test1.pdf');
      $manager->query($query);
      $this->view->query = (string)$query;
    }

}

