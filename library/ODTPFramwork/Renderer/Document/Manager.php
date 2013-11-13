<?php

class ODTPFramwork_Renderer_Document_Manager extends ODTPFramwork_Renderer_Document_Manager_Abstract
{
	public function init($files)
	{
		parent::init($files);
		if (is_null($files)) {

			return;
		}
		foreach ($files as $file) {
			$this->addDocument($file);
		}
	}

	public function addDocument($file)
	{
		$document = new ODTPFramwork_Renderer_Document($file);
		echo '<pre>' . print_r($document, true) . '</pre>';die;
	}
}
