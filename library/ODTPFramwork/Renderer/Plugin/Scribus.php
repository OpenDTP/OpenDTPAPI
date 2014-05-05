<?php

/**
 * Scribus Renderer class
 */
class ODTPFramwork_Renderer_Plugin_Scribus extends ODTPFramwork_Renderer_Plugin_Abstract
{
    protected $_client = null;

    public function init($parameters = null)
    {
        parent::init($parameters);
        $this->_client = new Zend_Http_Client();
    }

    /**
     * Send a query to renderer
     *
     * @param  ODTPFramwork_Renderer_Query_Interface $query The query to send to renderer
     *
     * @return ODTPFramwork_Renderer_Response_Interface
     */
    public function query(ODTPFramwork_Renderer_Query_Interface $query)
    {
        $uri = 'http://' . $this->getHost() . ':' . $this->getPort() . '/' . $query->getAction();
        $parameters = $query->getParameters();
        $inputs = $query->getInput();

        if (!empty($inputs)) {
            $uri .= '/' . implode('/', $inputs);
        }
        if (!empty($parameters)) {
            foreach ($parameters as $parameter) {
                $uri .= '/' . implode('/', $parameter);
            }
        }
        $this->_client->setUri($uri);

        //@TODO Add some error test ...
        $http_response = $this->_client->request();
        $response = new ODTPFramwork_Renderer_Response_Scribus($http_response->getBody(
        ), ODTPFramwork_Renderer_Response_Scribus::RESPONSE_JSON);
        $response->setCode($http_response->getStatus());
        $response->setHeader($http_response->getHeadersAsString());

        return $response;
    }

    /**
     * Check if renderer is available
     *
     * @return bool true if available
     */
    public function available()
    {
        $uri = 'http://' . $this->getHost() . ':' . $this->getPort();

        $this->_client->setUri($uri);
        $http_response = $this->_client->request();
        if (200 === $http_response->getStatus()) {
            return true;
        }

        return false;
    }
}
