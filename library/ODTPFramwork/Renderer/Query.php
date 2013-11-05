<?php

/**
* Renderer query object
*/
class ODTPFramwork_Renderer_Query extends ODTPFramwork_Renderer_Query_Abstract
{
  protected $_parser_class_name = 'ODTPFramwork_Renderer_Query_Parser';

  public function __construct($query_string = null)
  {
    $this->init($query_string);
  }

  public function init($query_string = null)
  {
    if (!is_null($query_string)) {
      $parser_class_name = $this->getParserClassName();
      $parser = new $parser_class_name();
      $elements = $parser->parseString($query_string);
    }
  }

  /**
   * Getters and Setters
   */

  public function getParserClassName()
  {
    return $this->_parser_class_name;
  }

  public function setParserClassName($parser_class_name)
  {
    if (!is_string($parser_class_name)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$parser_class_name must be a string');
    }
    $this->_parser_class_name = $parser_class_name;
  }
}
