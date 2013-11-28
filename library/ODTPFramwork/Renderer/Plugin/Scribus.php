<?php

/**
* Scribus Renderer class
*/
class ODTPFramwork_Renderer_Plugin_Scribus extends ODTPFramwork_Renderer_Plugin_Abstract
{
	protected $_client = null;

	public function init() {
		parent::init();
		$this->_client = new Zend_Http_Client();
	}

	/**
	 * Send a query to renderer
	 *
	 * @param  ODTPFramwork_Renderer_Query_Interface $query The query to send to renderer
	 * @return ODTPFramwork_Renderer_Response_Interface
	 */
	public function query(ODTPFramwork_Renderer_Query_Interface $query) {
		// $uri = 'http://' . $this->getHost() . ':';
		// $this->_client->setUri('http://82.244.76.215/setText.py/' . $file . '/' . urlencode($text));
    // $this->_client->request();
    throw new ODTPFramwork_Renderer_Exception('Renderer unavailable');
	}

	/**
	 * Check if renderer is available
	 *
	 * @return bool true if available
	 */
	public function available() {
		parent::available();
	}
}
