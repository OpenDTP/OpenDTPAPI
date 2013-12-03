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

		// @TODO : type matching must be defined in ini configutarion file
		$manager = new ODTPFramwork_Renderer_Document_Manager($query->getInput(), array('scribus' => array('sla')));
		$responses = array();
		foreach ($manager->getDocuments() as $renderer => $documents) {
			$has_renderer_available = false;
			foreach ($this->getPlugins($renderer) as $plugin) {
				try {
					$responses[] = $plugin->query($query);
					$has_renderer_available = true;
					break;
				} catch (ODTPFramwork_Renderer_Exception $e) {
				}
			}
			if (!$has_renderer_available) {
				throw new ODTPFramwork_Renderer_Manager_Exception("No renderer $renderer available");
			}
		}

		return $responses;
	}
}
