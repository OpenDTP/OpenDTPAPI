<?php

/**
* Renderer manager.
* Main class for querying renderers
*/
class ODTPFramwork_Renderer_Manager_Abstract implements ODTPFramwork_Renderer_Manager_Interface
{
	protected $_loader_class_name = 'ODTPFramwork_Renderer_Loader';
	protected $_loader = null;

	public function __construct($path) {
		$this->init($path);
	}

	protected function init($path)
	{
    	$loader_class_name = $this->getLoaderClassName();
        $this->_loader = new $loader_class_name();
        if (is_dir($path))
            $this->_plugins = $this->_loader->loadConfigFolder($filepath);
        else
            $this->_plugins = $this->_loader->loadConfigFile($filepath);
	}

	/**
	 * This method must be implemented.
	 *
	 * @throws ODTPFramwork_Renderer_Manager_Exception If not implemented
	 * @return null
	 */
	public function query() {
		throw new ODTPFramwork_Renderer_Manager_Exception("This method must be implemented");
	}

	/**
	 * Getters and setters
	 */

	/**
	 * Return renderer loader class name
	 *
	 * @return string
	 */
	public function getLoaderClassName() { return $this->_loader_class_name; }

	/**
	 * Return renderer loader.
	 *
	 * @return ODTPFramwork_Renderer_Manager_Interface
	 */
	public function getLoader() { return $this->_loader; }

	/**
	 * Set renderer loader class name
	 *
	 * @param string $class_name The renderer loader class name
	 * @throws ODTPFramwork_Renderer_Manager_Exception If $class_name is not a string or does not exists
	 * @return null
	 */
	public function setLoaderClassName($class_name) {
		if (!(is_string($class_name))) {
			throw new ODTPFramwork_Renderer_Manager_Exception('$class_name must be a string');
		}

		//@todo check if autoloader exists
		if (!class_exists($class_name)) {
			throw new ODTPFramwork_Renderer_Manager_Exception("$class_name does not exists");
		}
		$this->_loader_class_name = $class_name;
	}
}
