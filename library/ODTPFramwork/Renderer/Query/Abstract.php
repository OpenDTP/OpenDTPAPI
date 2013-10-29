<?php

/**
* Abstract class for renderer query object
*/
class ODTPFramwork_Renderer_Query_Abstract implements ODTPFramwork_Renderer_Query_Interface
{
    private $_input = '';
    private $_output = '';
    private $_action = '';
    private $_params = NULL;
    
    // Members
    /**
     * prints the command
     * @return string
     */
    public function __toString()
    {
        return $_action . $_input . $_output . $_params; 
    }
    
    // Setters
    /**
     * setInput value
     * @param string $src
     */
    public function setInput(string $src)
    {
        $this->$_input = $src;
    }
    /**
     * setOutput value
     * @param string $src
     */
    public function setOutput(string $src)
    {
        $this->$_output = $src;
    }
    /**
     * setAction value
     * @param string $action
     * @param array  $params
     */
    public function setAction(string $action, array $params)
    {
        $this->$_action = $action;
        $this->$_params = $params;
    }
    
    // Getters
    /**
     * getInput value
     * @return string
     */
    public function getInput()
    {
        return $this->$_input;
    }
    /**
     * getOutput value
     * @return string
     */
    public function getOutput()
    {
        return $this->$_output;
    }
    /**
     * getAction value
     * @return string
     */
    public function getAction()
    {
        return $this->$_action;
    }
}