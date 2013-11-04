<?php

class Renderer_IndexController extends ODTPFramwork_Controller
{

    public function indexAction() 
    {
    	$loader = Zend_Registry::get('RendererLoader');

    	// getting a renderer
    	$renderer = $loader->getRenderer('scr-default');
    	$this->view->id = $renderer->getId();

    }

}

