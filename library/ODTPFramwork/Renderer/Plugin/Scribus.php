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
		// $uri = 'http://' . $this->getHost() . ':' . $this->getPort();
		// $this->_client->setUri($uri);
		// $this->_client->request();
		// $response = new ODTPFramwork_Renderer_Response_Scribus('{"test":"valid"}', ODTPFramwork_Renderer_Response_Scribus::RESPONSE_JSON);
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
