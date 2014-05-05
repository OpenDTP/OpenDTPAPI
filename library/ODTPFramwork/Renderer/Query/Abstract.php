<?php

/**
 * Abstract class for renderer query object
 */
class ODTPFramwork_Renderer_Query_Abstract implements ODTPFramwork_Renderer_Query_Interface
{
    protected $_parameters = array();
    protected $_input = array();
    protected $_action = '';

    /**
     * prints the command
     *
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

    /**
     * Add a parameter in parameters list
     *
     * @param string $name   The parameter name
     * @param array  $values Parameter values
     *
     * @return null
     */
    public function addParameter($name, $values)
    {
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

    /**
     * Add input file to list
     *
     * @param string $file Input file to add
     *
     * @return null
     */
    public function addInput($file)
    {
        if (!is_string($file)) {
            throw new ODTPFramwork_Renderer_Query_Exception('$file must be a string');
        }
        if (!in_array($file, $this->_input)) {
            $this->_input[] = $file;
        }
    }

    /**
     * Getters and Setters
     */

    /**
     * Return the query action
     *
     * @return string The query action
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Return query input files
     *
     * @return array input files
     */
    public function getInput()
    {
        return $this->_input;
    }

    /**
     * Return query parameters
     *
     * @return array The query parameters
     */
    public function getParameters()
    {
        return $this->_parameters;
    }

    /**
     * Set query action
     *
     * @param string $action The query action
     *
     * @throws ODTPFramwork_Renderer_Query_Exception If $action is not a string
     * @return null
     */
    public function setAction($action)
    {
        if (!is_string($action)) {
            throw new ODTPFramwork_Renderer_Query_Exception('$action must be a string');
        }
        $this->_action = $action;
    }
}
