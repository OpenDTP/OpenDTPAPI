<?php
/**
 * @see Zend_Controller_Plugin_Abstract
 */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * @see Zend_Controller_Request_Http
 */
require_once 'Zend/Controller/Request/Http.php';

class ODTPFramwork_Controller_Plugin_DeleteHandler extends Zend_Controller_Plugin_Abstract
{
    /**
     * Before dispatching, digest PUT request body and set params
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (!$request instanceof Zend_Controller_Request_Http) {
            return;
        }

        if ($this->_request->isDelete()) {
            $deleteParams = array();
            parse_str($this->_request->getRawBody(), $deleteParams);
            $request->setParams($deleteParams);
        }
    }
}
