<?php

/**
 * Plugin to digest PUT request body and make params available just like POST
 *
 * @package    Zend_Controller
 * @subpackage Zend_Controller_Plugin
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class ODTPFramwork_Controller_Plugin_PutHandler extends Zend_Controller_Plugin_Abstract
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

        if ($this->_request->isPut()) {
            $putParams = array();
            parse_str($this->_request->getRawBody(), $putParams);
            $request->setParams($putParams);
        }
    }
}
