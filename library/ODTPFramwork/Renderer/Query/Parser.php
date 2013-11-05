<?php

class ODTPFramwork_Renderer_Query_Parser
{
	protected $_keywords = array(
		'render', 'deconstruct', 'getinfo', 'input', 'output'
	);

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
		$current_keyword = null;
		foreach ($parameters as $parameter) {
			$lower_parameter = strtolower($parameter);
			if (!in_array($lower_parameter, $this->_keywords) && is_null($current_keyword)) {
				throw new ODTPFramwork_Renderer_Query_Exception("Parse error in query : $str --- Near : $parameter");
			} else if (in_array($lower_parameter, $this->_keywords)) {
				$current_keyword = $lower_parameter;
			} else {
				if (isset($parsed_query[$current_keyword])) {
					throw new ODTPFramwork_Renderer_Query_Exception("Parse error in query : $str --- Near : $parameter");
				}
				$parsed_query[$current_keyword] = $parameter;
				$current_keyword = null;
			}
		}

		return $parsed_query;
	}
}
