<?php

/**
* Renderer manager.
* Main class for querying renderers
*/
class ODTPFramwork_Renderer_Manager_Abstract implements ODTPFramwork_Renderer_Manager_Interface
{
	protected $_loader_class_name = 'ODTPFramwork_Renderer_Loader';
	protected $_loader = null;
	protected $_plugins = array();

	public function __construct($path) {
		$this->init($path);
	}

	protected function init($path)
	{
		if (!is_string($path)) {
			throw new ODTPFramwork_Renderer_Manager_Exception('$path must be a string');
		}
  	$loader_class_name = $this->getLoaderClassName();
    $this->setLoader(new $loader_class_name());
    if (is_dir($path)) {
			$this->getLoader()->loadConfigFolder($path);
    } else {
			$this->getLoader()->loadConfigFile($path);
    }
    $plugins = $this->getLoader()->getRenderers();
    foreach ($plugins as $plugin) {
    	$this->pushPlugin($plugin);
    }
	}

	/**
	 * This method must be implemented.
	 *
	 * @throws ODTPFramwork_Renderer_Manager_Exception If not implemented
	 * @return null
	 */
	public function query(ODTPFramwork_Renderer_Query_Interface $query)
	{
		throw new ODTPFramwork_Renderer_Manager_Exception("This method must be implemented");
	}

	/**
	 * Push a plugin in the manager for further use
	 *
	 * @param  ODTPFramwork_Renderer_Plugin_Interface $plugin The plugin to push
	 * @throws ODTPFramwork_Renderer_Manager_Exception If Plugin ID is not set
	 * @throws ODTPFramwork_Renderer_Manager_Exception If Plugin Type is not set
	 * @return null
	 */
	public function pushPlugin(ODTPFramwork_Renderer_Plugin_Interface $plugin)
	{
		if (!is_string($plugin->getId())) {
			throw new ODTPFramwork_Renderer_Manager_Exception('Plugin ID is not set');
		}
		if (!is_string($plugin->getType())) {
			throw new ODTPFramwork_Renderer_Manager_Exception('Plugin type is not set for plugin : ' . $plugin->getId());
		}
		if (!isset($this->_plugins[$plugin->getType()])) {
			$this->_plugins[$plugin->getType()] = array();
		}
		$this->_plugins[$plugin->getType()][$plugin->getId()] = $plugin;
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
	 * Return manager plugins
	 *
	 * @return ODTPFramwork_Renderer_Plugin_Interface
	 */
	public function getPlugins() { return $this->_plugins; }

	/**
	 * Set renderer loader class name
	 *
	 * @param string $class_name The renderer loader class name
	 * @throws ODTPFramwork_Renderer_Manager_Exception If $class_name is not a string or does not exists
	 * @return null
	 */
	public function setLoaderClassName($class_name)
	{
		if (!(is_string($class_name))) {
			throw new ODTPFramwork_Renderer_Manager_Exception('$class_name must be a string');
		}

		//@todo check if loader exists
		if (!class_exists($class_name)) {
			throw new ODTPFramwork_Renderer_Manager_Exception("$class_name does not exists");
		}
		$this->_loader_class_name = $class_name;
	}

	/**
	 * Define a renderer loader
	 *
	 * @param ODTPFramwork_Renderer_Loader_Interface $loader The renderer loader class name
	 * @return null
	 */
	public function setLoader(ODTPFramwork_Renderer_Loader_Interface $loader)
	{
		$this->_loader = $loader;
	}
}
