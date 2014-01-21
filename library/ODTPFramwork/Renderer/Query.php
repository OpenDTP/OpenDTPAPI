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

  /**
   * Query initialisation.
   * Can load a query String.
   *
   * @param  string $query_string A query string for query object initialisation
   * @return null
   */
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

  /**
   * Load an array from a parsed query to set action and it's input files
   *
   * @param array $action Parsed Query action part
   * @throws ODTPFramwork_Renderer_Query_Exception If $action is not a string
   * @return null
   */
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

  /**
   * Set additional parameters for query
   *
   * @param array $parameters Parameters to load from parsed query
   * @throws ODTPFramwork_Renderer_Query_Exception If $parameters is not an array and not null
   * @return null
   */
  protected function setParametersFromParsedQuery($parameters)
  {
    if (is_null($parameters)) {

      return ;
    }
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

  /**
   * Return Parser class name to load
   *
   * @return string  Parser class name
   */
  public function getParserClassName()
  {
    return $this->_parser_class_name;
  }

  /**
   * Set Parser class name to load
   *
   * @param string $parser_class_name The parser class name
   * @throws ODTPFramwork_Renderer_Query_Exception If $parser_class_name is not a string
   * @throws ODTPFramwork_Renderer_Query_Exception If $parser_class_name class does not exists
   * @return null
   */
  public function setParserClassName($parser_class_name)
  {
    if (!is_string($parser_class_name)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$parser_class_name must be a string');
    }
    if (!class_exists($parser_class_name)) {
      throw new ODTPFramwork_Renderer_Query_Exception("Unknown class $parser_class_name");
    }
    $this->_parser_class_name = $parser_class_name;
  }
}
