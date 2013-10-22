<?php

/**
* Abstract class for renderer query object
*/
class ODTPFramwork_Renderer_Query_Abstract implements ODTPFramwork_Renderer_Query_Interface
{
    private $_input;
    private $_output;
    private $_action;
    private $_params;
    
    // Members
    
    public function _toString()
    {
        
    }
    
    // Setters
    
    public function setInput($src)
    {
        $this->$_input = $src;
    }

    public function setOutput($src)
    {
        $this->$_output = $src;
    }
    
    public function setAction($action, $params)
    {
        $this->$_action = $action;
        $this->$_params = $params;
    }
    
    // Getters
    
    public function getInput()
    {
        return $this->$_input;
    }
    
    public function getOutput()
    {
        return $this->$_output;
    }
    
    public function getAction()
    {
        return $this->$_action;
    }
}