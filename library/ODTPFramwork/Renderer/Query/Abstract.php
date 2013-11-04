<?php

/**
* Abstract class for renderer query object
*/
class ODTPFramwork_Renderer_Query_Abstract implements ODTPFramwork_Renderer_Query_Interface
{
  private $_parameters = array();
  private $_input = array();
  private $_action = '';

  /**
   * prints the command
   * @return string
   */
  public function __toString()
  {
    $query_string = strtoupper($this->getAction());

    if (!empty($this->_input)) {
      $query_string .= ' ' . implode(', ', $this->getInput());
    }
    foreach ($this->getParameters() as $name => $values) {
      $query_string .= ' ' . strtoupper($name);
      if (!empty($values)) {
        $query_string .= ' ' . implode(', ', $values);
      }
    }

    return $query_string;
  }

  public function addParameters($name, $values) {
    if (!is_string($name)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$name must be a string');
    }
    if (!is_array($values)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$values must be an array');
    }
    if (!isset($this->_parameters[$name])) {
      $this->_parameters[$name] = $values;
    } else {
      $this->_parameters[$name] = array_merge($this->_parameters[$name], $values);
    }
  }

  public function addInput($file) {
    if (!is_string($file)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$file must be a string');
    }
    if (!in_array($file, $this->_input)) {
      $this->_input[] = $file;
    }
  }

  public function getAction() { return $this->_action; }
  public function getInput() { return $this->_input; }
  public function getParameters() { return $this->_parameters; }

  public function setAction($action) {
    if (!is_string($action)) {
      throw new ODTPFramwork_Renderer_Query_Exception('$action must be a string');
    }
    $this->_action = $action;
  }
}
