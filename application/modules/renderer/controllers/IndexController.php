<?php

class Renderer_IndexController extends ODTPFramwork_Controller
{

    public function indexAction()
    {
    	$loader = Zend_Registry::get('RendererLoader');
    	$query = new ODTPFramwork_Renderer_Query();

    	$query->setAction('render');
    	$query->addInput('test.sla');
    	$query->addInput('test2.sla');
    	$query->addParameters('output', array('test.pdf', 'test2.pdf'));

    	// getting a renderer
    	$renderer = $loader->getRenderer('scr-default');
    	$this->view->id = $renderer->getId();
    	$this->view->debug = (string)$query;

    }

}

