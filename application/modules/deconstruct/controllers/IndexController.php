<?php

class Deconstruct_IndexController extends ODTPFramwork_Controller
{

    public function getAction()
    {
        $document = $this->getRequest()->getParam('document');

        try {
            $query = new ODTPFramwork_Renderer_Query('DECONSTRUCT ' . $document);
            Zend_Registry::get('RendererManager')->query($query);
            $this->view->file = $document . '.xml';
        } catch (Exception $e) {
            $this->setException($e);
        }
    }

}

