<?php

class ODTPFramwork_Renderer_Query_Parser 
{
	private $_inputArray = NULL;
	private $_outputArray = NULL;
	private $_optionsArray = array(array("render", "output"),
								   array("update", "in")
								  );
/**
* parses the provided command
* @return multidimensional array
*/
private function parseString(string $str)
{
	private string $_arrayName = "input";

	$_inputArray = explode(" ", $str);
	if (strcasecmp(array_shift(array_values($_inputArray)), "render"))
	{
		foreach ($_inputArray as $element)
		{
			if ((strcasecmp($element, "output")))
				$_arrayName = "output";

			if (!(strcasecmp($_arrayName, "render")))
				$_outputArray[$_arrayName] = $element;	
		}
	}
	return $_outputArray;
}