<?php

class Render_IndexController extends ODTPFramwork_Controller
{
    public function getAction()
    {
        $document = $this->getRequest()->getParam('document');
        $type = $this->getRequest()->getParam('type');
        $page = $this->getRequest()->getParam('page');
        $scale = $this->getRequest()->getParam('scale');

        try {
            // Should be construct with the query builder in 0.3 version
            // Furthermore keywords for option should be changed
            // with something more like WITH SCALE=100 for exemple
            $queryString = 'RENDER ' . $document . ' TYPE ' .
                ($type ? $type : 'jpeg') . ' SCALE ' . ($scale ? $scale : 100)
                . ' PAGE ' . ($page ? $page : 'ALL');
            $query = new ODTPFramwork_Renderer_Query($queryString);
            $responses = Zend_Registry::get('RendererManager')->query($query);

            //@TODO Add some dynamism and use scribus output
            $this->view->file = $document . '.' . strtolower($type);
            $this->view->response = $responses[0]->getResponse();
        } catch (Exception $e) {
            $this->setException($e);
        }
    }
}
