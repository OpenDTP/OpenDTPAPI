<?php

class ODTPFramwork_Renderer_Document_Manager extends ODTPFramwork_Renderer_Document_Manager_Abstract
{
	public function init($files = null, $type_matching = array())
	{
		parent::init($files);
		if (is_null($files)) {

			return;
		}
		if (!empty($type_matching)) {
			$this->setTypeMatching($type_matching);
		}
		foreach ($files as $file) {
			$this->addDocument($file);
		}
	}

	protected function find_renderer(ODTPFramwork_Renderer_Document_Interface $document)
	{
		$i = 0;

		foreach ($this->getTypeMatching() as $renderer => $extensions) {
			if (in_array($document->getExtension(), $extensions)) {
				return ($renderer);
			}
		}

		return null;
	}

	public function addDocument($file, $renderer = null)
	{
		if (!is_string($file)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception('$file must be a string');
		}
		$document = new ODTPFramwork_Renderer_Document($file);
		if (is_null($renderer)) {
			$renderer = $this->find_renderer($document);
			if (is_null($renderer)) {
				throw new ODTPFramwork_Renderer_Document_Manager_Exception('Unknown extension ' . $document->getExtension() . ' : can\'t define renderer');
			}
		} else if (!$this->renderer_defined($renderer)) {
			throw new ODTPFramwork_Renderer_Document_Manager_Exception("Unknown renderer $renderer");
		}
		$document->setRenderer($renderer);
		$document_id = md5($file);
		$this->_documents[$document_id] = $document;

		return $document_id;
	}
}
