<?php

class ODTPFramwork_Renderer_Document_Manager_Abstract implements ODTPFramwork_Renderer_Document_Manager_Interface
{
	protected $_documents = array();

	public function __construct($files = null)
	{
		$this->init($files);
	}

	public function init($files)
	{
		if (!is_null($files) && !is_array($files)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception('$files must be an array');
		}
	}

	public function addDocument($file)
	{
		throw new ODTPFramwork_Renderer_Document_Manager_Exception("This method must be implemented");
	}

	/**
	 * Getters and Setters
	 */

	public function getDocuments()
	{
		return $this->_documents;
	}
}
