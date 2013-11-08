<?php

/**
* Connection manager for renderers
*/
class ODTPFramwork_Renderer_Manager extends ODTPFramwork_Renderer_Manager_Abstract
{
	public function init($parameters)
	{
		parent::init($parameters);
	}

	public function query(ODTPFramwork_Renderer_Query_Interface $query)
	{
		$plugins = $this->getPlugins();
		$renderers_count = count($plugins);
		$i = 0;
		$has_available = false;

		while (!$has_available && $i < $renderers_count) {
			try {
				$plugin->query($query);
				$has_available = true;
			} catch (ODTPFramwork_Renderer_Exception $e) {
				echo '<pre>' . print_r($e, true) . '</pre>';die;
			}
		}

		if (!$has_available) {
			throw new ODTPFramwork_Renderer_Manager_Exception("No renderer available");
		}
	}
}
