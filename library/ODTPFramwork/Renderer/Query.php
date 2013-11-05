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
    if (is_null($query_string)) {
      return;
    }
    $parser_class_name = $this->getParserClassName();
    $parser = new $parser_class_name();
    $elements = $parser->parseString($query_string);
    $this->setActionFromParsedQuery(array_slice($elements, 1, 1));
    $this->setParametersFromParsedQuery(array_slice($elements, 2));
  }

  protected function setActionFromParsedQuery($action)
  {
    if (!is_array($action)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$action must be an array');
    }
    $action_name = array_keys($action);
    $this->setAction($action_name[0]);
    foreach ($action[$action_name[0]] as $input) {
      $this->addInput($input);
    }
  }

  protected function setParametersFromParsedQuery($parameters)
  {
    if (!is_array($parameters)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$parameters must be an array');
    }
    foreach ($parameters as $name => $values) {
      $this->addParameter($name, $values);
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
