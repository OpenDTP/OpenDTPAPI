<?php

/**
* Interface for renderer plugins
*/
interface ODTPFramwork_Renderer_Plugin_Interface
{
	public function query(ODTPFramwork_Renderer_Query_Interface $query);
}
