<?php

/**
* Loader for Rederers
*/
class ODTPFramwork_Renderer_Loader implements ODTPFramwork_Renderer_Loader_Interface
{
	private $_default_config_path = '';
	private $_config_files_paths = array();
	private $_preload = false;
	private $_renderers = array();

	/**
	 * Set default parameters.
	 * Preload renderers if $_preload is set to true.
	 *
	 * @param array $parameters parameters to set
	 */
	public function __construct($parameters = null) {
		if (is_null($parameters)) {
			return null;
		}
		if (isset($parameters['default_config_path'])) {
			$this->setDefaultConfigPath($parameters['default_config_path']);
		}
		$this->setPreload(isset($parameters['preload']) ? $parameters['preload'] : false);
		if ('' !== $this->getDefaultConfigPath() && !$this->getPreload())
		{
			$this->loadConfigFolder();
		}
	}

	/**
	 * Register a plugin into loader if not already done.
	 *
	 * @param  ODTPFramwork_Renderer_Plugin_Abstract $renderer Renderer to register
	 * @return null
	 */
	public function registerRenderer(ODTPFramwork_Renderer_Plugin_Abstract $renderer) {
		if (!isset($this->_renderers[$renderer->getId()])) {
			$this->_renderers[$renderer->getId()] = $renderer;
		}
	}

	/**
	 * Load config file and stock the resulting renderer
	 *
	 * @param  string $filepath The config file to load
	 * @return null
	 */
	public function loadConfigFile($filepath) {
		$factory = ODTPFramwork_Renderer_Factory::getInstance();
		$renderer = $factory->factory($filepath);
		$this->registerRenderer($renderer);
	}

	/**
	 * Load all config files in default path if $path is null.
	 *
	 * @param array $path Folder to load.
	 * @throws ODTPFramwork_Renderer_Exception If $path is null and $this->_config_files_paths is not set
	 * @throws ODTPFramwork_Renderer_Exception If $path is not an array and is not null
	 * @throws ODTPFramwork_Renderer_Exception If Couldn't open $this->_config_files_paths directory
	 * @return null
	 */
	public function loadConfigFolder($path = null)
	{
		if (is_null($path) && '' === $this->getDefaultConfigPath())
			throw new ODTPFramwork_Renderer_Exception('use setDefaultConfigPath() first.');
		if (!is_null($path) && !is_string($path))
			throw new ODTPFramwork_Renderer_Exception('$path must be an string');
		if (is_null($path))
			$path = $this->getDefaultConfigPath();
		if (!is_dir($path))
			throw new ODTPFramwork_Renderer_Exception("$path must be a folder");
		$dir = @opendir($path);
		if (false === $dir)
	    	throw new ODTPFramwork_Renderer_Exception("$path : Couldn't open folder");
		$file = '';
		while (false !== ($file = readdir($dir))) {
			if (is_file($path . DIRECTORY_SEPARATOR . $file))
				$this->loadConfigFile($path . DIRECTORY_SEPARATOR . $file);
		}
	}

	/**
	 * Return renderer designed by name.
	 *
	 * @param  string $name Name of renderer to return.
	 * @throws ODTPFramwork_Renderer_Exception If $name is not a string.
	 * @throws ODTPFramwork_Renderer_Exception If renderer is not loaded.
	 * @return ODTPFramwork_Renderer_Plugin_Interface
	 */
	public function getRenderer($name) {
		if (!is_string($name)) {
			throw new ODTPFramwork_Renderer_Exception('$name must be a string');
		}
		if (!isset($this->_renderers[$name])) {
			throw new ODTPFramwork_Renderer_Exception("Unknown renderer $name");
		}

		return $this->_renderers[$name];
	}

	/**
	 * Getters and Setters
	 */

	/**
	 * The default path loader will look into for plugin loading
	 *
	 * @return string
	 */
	public function getDefaultConfigPath() { return $this->_default_config_path; }

	/**
	 * Return all config file loaded
	 *
	 * @todo  not used for now ...
	 * @return array
	 */
	public function getConfigFilesPaths() { return $this->_config_files_paths; }

	/**
	 * Return the preload value.
	 * If true the loader will instanciate all renderers on instanciation.
	 *
	 * @return boolean
	 */
	public function getPreload() { return $this->_preload; }

	/**
	 * Return all loaded renderers
	 *
	 * @return array
	 */
	public function getRenderers() { return $this->_renderers; }

	/**
	 * Set the default path loader will look into for plugin loading
	 *
	 * @param string $path The default path loader will look into for plugin loading
	 * @throws ODTPFramwork_Renderer_Exception If $path is null or not a string
	 * @return null
	 */
	public function setDefaultConfigPath($path) {
		if (!is_string($path)) {
			throw new ODTPFramwork_Renderer_Exception('$path is not a string');
		}
		if (!is_dir($path)) {
			throw new ODTPFramwork_Renderer_Exception("$path does not exists or is not a folder");
		}
		$this->_default_config_path = $path;
	}

	/**
	 * Set the preload value.
	 *
	 * @param boolean $preload If true the loader will instanciate all renderers on instanciation.
	 * @throws ODTPFramwork_Renderer_Exception If $preload is not a boolean
	 * @return null
	 */
	public function setPreload($preload) {
		if (!is_bool($preload)) {
			throw new ODTPFramwork_Renderer_Exception('$preload must be a boolean');
		}
		$this->_preload = $preload;
	}
}
