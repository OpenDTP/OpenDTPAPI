<?php

class ODTPFramwork_Renderer_Document_Abstract implements ODTPFramwork_Renderer_Document_Interface
{

	protected $_name;
	protected $_file;
	protected $_path;
	protected $_extension;

	public function __construct($file)
	{
		$this->init($file);
	}

	public function init($file)
	{
		if (!is_string($file)) {
			throw new ODTPFramwork_Renderer_Document_Exception('$file must be a string');
		}
	}

	/**
	 * Getters and Setters
	 */

	public function getName()
	{
		return $this->_name;
	}

	public function getFile()
	{
		return $this->_file;
	}

	public function getPath()
	{
		return $this->_path;
	}

	public function getExtension()
	{
		return $this->_extension;
	}

	public function setName($name)
	{
		if (!is_string($name)) {
			throw new ODTPFramwork_Renderer_Document_Exception('$name must be a string');
		}
		$this->_name = $name;
	}

	public function setFile($file)
	{
		if (!is_string($file)) {
			throw new ODTPFramwork_Renderer_Document_Exception('$file must be a string');
		}
		$this->_file = $file;
	}

	public function setPath($path)
	{
		if (!is_string($path)) {
			throw new ODTPFramwork_Renderer_Document_Exception('$path must be a string');
		}
		$this->_path = $path;
	}

	public function setExtension($extension)
	{
		if (!is_string($extension)) {
			throw new ODTPFramwork_Renderer_Document_Exception('$extension must be a string');
		}
		$this->_extension = $extension;
	}

}
