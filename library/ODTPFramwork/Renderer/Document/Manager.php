<?php

class ODTPFramwork_Renderer_Document_Manager extends ODTPFramwork_Renderer_Document_Manager_Abstract
{
	public function init($files = null, $type_matching = array())
	{
		parent::init($files);
		if (is_null($files)) {

			return;
		}
		foreach ($files as $file) {
			$this->addDocument($file, 'scribus');
		}
	}

	public function addDocument($file, $renderer = null)
	{
		if (!is_string($file)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception('$file must be a string');
		}
		$document = new ODTPFramwork_Renderer_Document($file);
		if (!is_null($renderer)) {
			$document->setRenderer($renderer);
		}
		$this->_documents[md5($file)] = $document;
	}
}
