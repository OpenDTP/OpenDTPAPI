<?php

class ODTPFramwork_Renderer_Response_Abstract implements ODTPFramwork_Renderer_Response_Interface
{
	const RESPONSE_JSON = 'json';
	const RESPONSE_XML = 'xml';
	const RESPONSE_RAW = 'raw';

	protected $_code = 0;
	protected $_response = '';
	protected $_header = '';
	protected $_format = self::RESPONSE_RAW;

	public function __construct($response = null, $format = null) {
		$this->init($response, $format);
	}

	public function init($response = null, $format = null) {
		if (!is_null($response)) {
			$this->setResponse($response);
		}
		if (!is_null($format)) {
			$this->setFormat($format);
		}
	}

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

	protected function formatResponseRaw($message) {

		return $message;
	}

	public function setCode($code)
	{
		if (!is_int($code)) {
			throw new ODTPFramwork_Renderer_Response_Exception('$code must be an integer');
		}
		$this->_code = $code;
	}

	public function setResponse($response)
	{
		if (!is_string($response)) {
			throw new ODTPFramwork_Renderer_Response_Exception('$response must be a string');
		}
		$this->_response = $response;
	}

	public function setHeader($header)
	{
		if (!is_string($header)) {
			throw new ODTPFramwork_Renderer_Response_Exception('$header must be a string');
		}
		$this->_header = $header;
	}

	public function setFormat($format)
	{
		if (!is_string($format)) {
			throw new ODTPFramwork_Renderer_Response_Exception('$format must be a string');
		}
		$this->_format = $format;
	}

	public function getCode()
	{

		return $this->_code;
	}

  public function getResponse($format = null)
  {
  	if (!is_null($format) && !is_string($format)) {
  		throw new ODTPFramwork_Renderer_Response_Exception('$format must be a string');
  	}
  	if (is_null($format)) {
  		$format = $this->getFormat();
  	}
  	$callback = 'formatResponse' . ucwords($format);
  	if (!method_exists($this, $callback)) {
  		throw new ODTPFramwork_Renderer_Response_Exception("Unknown format $format");
  	}

  	return $this->$callback($this->_response);
  }

  public function getHeader()
  {

  	return $this->_header;
  }

  public function getFormat()
  {

  	return $this->_format;
  }
}
