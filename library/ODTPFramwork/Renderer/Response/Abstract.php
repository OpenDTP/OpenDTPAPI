<?php

class ODTPFramwork_Renderer_Response_Abstract implements ODTPFramwork_Renderer_Response_Interface
{
    /**
     * Response in JSON format
     */
    const RESPONSE_JSON = 'json';

    /**
     * Response in XML format
     */
    const RESPONSE_XML = 'xml';

    /**
     * Response is not parsed
     */
    const RESPONSE_RAW = 'raw';

    protected $_code = 0;
    protected $_response = '';
    protected $_header = '';
    protected $_format = self::RESPONSE_RAW;

    public function __construct($response = null, $format = null)
    {
        $this->init($response, $format);
    }

    public function init($response = null, $format = null)
    {
        if (!is_null($response)) {
            $this->setResponse($response);
        }
        if (!is_null($format)) {
            $this->setFormat($format);
        }
    }

    /**
     * Hook for JSON responses. Format response before returning it.
     *
     * @param  string $message The response message.
     *
     * @throws ODTPFramwork_Renderer_Response_Exception If $message is not a string
     * @throws ODTPFramwork_Renderer_Response_Exception If json_decode throw an invalid format exception
     * @throws ODTPFramwork_Renderer_Response_Exception If json_decode can't decode $message and return null
     * @return stdClass    The parsed JSON string
     */
    protected function formatResponseJson($message)
    {
        if (!is_string($message)) {
            throw new ODTPFramwork_Renderer_Response_Exception('$message must be a string');
        }
        try {
            $decoded = json_decode($message);
        } catch (Exception $e) {
            throw new ODTPFramwork_Renderer_Response_Exception('Invalid JSON string');
        }
        if (is_null($decoded)) {
            throw new ODTPFramwork_Renderer_Response_Exception('Couldn\'t decode JSON string');
        }

        return $decoded;
    }

    /**
     * Hook for XML responses. Format response before returning it.
     *
     * @param  string $message The response message.
     *
     * @throws ODTPFramwork_Renderer_Response_Exception If $message is not a string
     * @throws ODTPFramwork_Renderer_Response_Exception If SimpleXMLElement throw an invalid format exception
     * @throws ODTPFramwork_Renderer_Response_Exception If SimpleXMLElement can't decode $message and return null
     * @return SimpleXMLElement    The parsed JSON string
     */
    protected function formatResponseXml($message)
    {
        if (!is_string($message)) {
            throw new ODTPFramwork_Renderer_Response_Exception('$message must be a string');
        }
        try {
            $decoded = new SimpleXMLElement($message);
        } catch (Exception $e) {
            throw new ODTPFramwork_Renderer_Response_Exception('Invalid XML string');
        }
        if (is_null($decoded)) {
            throw new ODTPFramwork_Renderer_Response_Exception('Couldn\'t decode XML string');
        }

        return $decoded;
    }

    /**
     * Return the response string intact.
     *
     * @param  mixed $message The response message
     *
     * @return mixed    The response message
     */
    protected function formatResponseRaw($message)
    {

        return $message;
    }

    /**
     * Getters and Setters
     */

    /**
     * Set the HTTP response code
     *
     * @param int $code The HTTP response code
     *
     * @throws ODTPFramwork_Renderer_Response_Exception If $code is not an int
     * @return null
     */
    public function setCode($code)
    {
        if (!is_int($code)) {
            throw new ODTPFramwork_Renderer_Response_Exception('$code must be an integer');
        }
        $this->_code = $code;
    }

    /**
     * Set the response message
     *
     * @param string $response The response message
     *
     * @throws ODTPFramwork_Renderer_Response_Exception If $response is not a string
     * @return null
     */
    public function setResponse($response)
    {
        if (!is_string($response)) {
            throw new ODTPFramwork_Renderer_Response_Exception('$response must be a string');
        }
        $this->_response = $response;
    }

    /**
     * Set the response HTML header
     *
     * @param string $header The header to set
     *
     * @throws ODTPFramwork_Renderer_Response_Exception If $header is not a string
     * @return null
     */
    public function setHeader($header)
    {
        if (!is_string($header)) {
            throw new ODTPFramwork_Renderer_Response_Exception('$header must be a string');
        }
        $this->_header = $header;
    }

    /**
     * Set the response format
     *
     * @param string $format The header to set
     *
     * @throws ODTPFramwork_Renderer_Response_Exception If $format is not a string
     * @return null
     */
    public function setFormat($format)
    {
        if (!is_string($format)) {
            throw new ODTPFramwork_Renderer_Response_Exception('$format must be a string');
        }
        $this->_format = $format;
    }

    /**
     * Return the HTTP response code
     *
     * @return int The response code
     */
    public function getCode()
    {

        return $this->_code;
    }

    /**
     * Return the formated response.
     * $format param has priority over class attribute.
     *
     * @param  string $format Force the response format.
     *
     * @throws ODTPFramwork_Renderer_Response_Exception If $format is not null and not a string
     * @throws ODTPFramwork_Renderer_Response_Exception If $format is an unknown format
     * @return mixed    Returning a response depending on $format parameter or attribute
     */
    public function getResponse($format = null)
    {
        if (!is_null($format) && !is_string($format)) {
            throw new ODTPFramwork_Renderer_Response_Exception('$format must be a string');
        }
        if (is_null($format)) {
            $format = $this->getFormat();
        }

        // Set the callback name and call it if exists
        $callback = 'formatResponse' . ucwords($format);
        if (!method_exists($this, $callback)) {
            throw new ODTPFramwork_Renderer_Response_Exception("Unknown format $format");
        }

        return $this->$callback($this->_response);
    }

    /**
     * Return the HTTP header
     *
     * @return string The response HTTP header
     */
    public function getHeader()
    {

        return $this->_header;
    }

    /**
     * Return the response format
     *
     * @return string The response format
     */
    public function getFormat()
    {

        return $this->_format;
    }
}
