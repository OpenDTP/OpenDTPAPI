<?php

class ODTPFramwork_Renderer_Query_Parser 
{
	private $_inputArray = NULL;
	private $_outputArray = NULL;
	private $_optionsArray = array("render" => "output",
								   "update" => "in"
								  );

/**
* parses the provided command
* @return multidimensional array
*/
private function parseString(string $str)
{
	private string $_arrayName = "input";
	private string $_key = '';
	$_inputArray = explode(" ", $str);
	$_key = array_search($_inputArray[0], $_optionsArray)
	if (!empty($_key))
	{
		foreach ($_inputArray as $_element)
		{
			if ((strcasecmp($_element, $_key)))
			{
				$_outputArray[$_arrayName] = $_fieldArray;
				unset($_fieldArray);
				$_arrayName = "output";
			}
			if (!(strcasecmp($_element, $_inputArray[0])))
				array_push($_fieldArray, $_element);	
		}
	}
	return $_outputArray;
}