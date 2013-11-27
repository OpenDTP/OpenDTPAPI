<?php

class ODTPFramwork_Renderer_Document extends ODTPFramwork_Renderer_Document_Abstract
{
	protected $_renderer;

	public function init($file)
	{
		parent::init($file);
		if (!file_exists($file)) {
			throw new ODTPFramwork_Renderer_Document_Exception("$file not found");
		}
		$infos = pathinfo($file);
		$this->setName($infos['filename']);
		$this->setFile($infos['basename']);
		$this->setPath($infos['dirname']);
		$this->setExtension($infos['extension']);
	}

	/**
	 * Getters and setters
	 */

	public function getRenderer()
	{
		return $this->_renderer;
	}

	public function setRenderer($renderer)
	{
		if (!is_string($renderer)) {
			throw new ODTPFramwork_Renderer_Document_Exception('$renderer must be a string');
		}
		$this->_renderer = $renderer;
	}

}
