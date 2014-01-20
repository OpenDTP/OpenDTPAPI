<?php

class Render_IndexController extends ODTPFramwork_Controller
{

    public function getAction() {
    	$document = $this->getRequest()->getParam('document');
    	$type = $this->getRequest()->getParam('type');
    	$page = $this->getRequest()->getParam('page');

    	try {
    		$query_string = 'RENDER ' . $document;
    		if ($type) {
    			$query_string .= ' TYPE ' . $type;
    		}
    		$query = new ODTPFramwork_Renderer_Query($query_string);
				$responses = Zend_Registry::get('RendererManager')->query($query);

				//@TODO Add some dynamism and use scribus output
				$this->view->file = $document . '.' . strtolower($type);
				$this->view->response = $responses[0]->getResponse();
    	} catch (Exception $e) {
    		$this->setException($e);
    	}
    }

}

