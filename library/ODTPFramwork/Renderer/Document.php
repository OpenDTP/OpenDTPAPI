<?php

class ODTPFramwork_Renderer_Document extends ODTPFramwork_Renderer_Document_Abstract
{

	public function init($file)
	{
		parent::init($file);
		echo '<pre>' . print_r($file, true) . '</pre>';die;
	}

}
