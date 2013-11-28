<?php

class ODTPFramwork_Renderer_Document_Manager_Abstract implements ODTPFramwork_Renderer_Document_Manager_Interface
{
	protected $_documents = array();
	protected $_type_matching = array();

	public function __construct($files = null, $type_matching = array())
	{
		$this->init($files, $type_matching);
	}

	public function init($files = null, $type_matching = array())
	{
		if (!is_null($files) && !is_array($files)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception('$files must be an array');
		}
		if (!empty($type_matching) && !is_array($type_matching)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception('$type_matching must be an array');
		}
	}

	public function addDocument($file)
	{
		throw new ODTPFramwork_Renderer_Document_Manager_Exception("This method must be implemented");
	}

	/**
	 * Getters and Setters
	 */

	public function getDocuments($type = null)
	{
		if (!is_null($type) && !is_string($type)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception('$type must be a boolean');
		}
		if (!$type) {
			return $this->_documents;
		}
		$documents = array();
		foreach ($this->_documents as $document) {
			if ($type === $document->getRenderer()) {
				$documents[] = $document;
			}
		}

		return $documents;
	}

	public function getTypeMatching()
	{

		return $this->_type_matching;
	}

	public function setTypeMatching($type_matching)
	{
		if (!is_array($type_matching)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception('$type_matching must be an array');
		}
		$this->_type_matching = $type_matching;
	}
}
