<?php

/**
* Scribus Renderer class
*/
class ODTPFramwork_Renderer_Plugin_Scribus extends ODTPFramwork_Renderer_Plugin_Abstract
{
	/**
	 * Send a query to renderer
	 *
	 * @param  ODTPFramwork_Renderer_Query_Interface $query The query to send to renderer
	 * @return ODTPFramwork_Renderer_Response_Interface
	 */
	public function query(ODTPFramwork_Renderer_Query_Interface $query) {
		parent::query();
	}
}
