<?php

class ODTPFramwork_Renderer_Query_Parser
{
	/**
	* parses the provided command
	* @return multidimensional array
	*/
	public function parseString($str)
	{
		if (!is_string($str)) {
			throw new ODTPFramwork_Renderer_Query_Exception('$str must be a string');
		}
		$parsed_query = array();
		$formated_query = preg_replace('#[\s]*([,=])[\s]*#', '$1', $str);
		$parameters = explode(' ', $formated_query);
		foreach ($parameters as $parameter) {
			$parsed_query[] = $parameter;
		}

		echo '<pre>' . print_r($parsed_query, true) . '</pre>';die;
		return $parsed_query;
	}
}
