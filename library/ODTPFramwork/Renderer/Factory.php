<?php

/**
 * PAO Renderer factory.
 * Generate OODTPFramwork_Renderer_Plugin plugins
 */
class ODTPFramwork_Renderer_Factory
{
    public static $_instance;

    private $_plugin_prefix = 'ODTPFramwork_Renderer_Plugin_';

    /**
     * Private constructor for singleton pattern
     */
    private function __construct()
    {
    }

    /**
     * Users shouldn't be able to clone a singleton instance
     *
     * @throws ODTPFramwork_Renderer_Exception If __clone is called
     * @return null
     */
    public function __clone()
    {
        throw new ODTPFramwork_Renderer_Exception("Cloning is forbidden");
    }

    /**
     * Users shouldn't be able to unserialize a singleton instance
     *
     * @throws ODTPFramwork_Renderer_Exception If __wakeup is called
     */
    public function __wakeup()
    {
        throw new ODTPFramwork_Renderer_Exception("Unserializing is forbidden");
    }

    /**
     * Singleton instance accessor
     *
     * @return ODTPFramwork_Renderer_Factory
     */
    public static function &getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Instanciate a renderer object from config file.
     *
     * @param  string $filepath Renderer configuration file path
     *
     * @throws ODTPFramwork_Renderer_Exception If $filepath is not a string
     * @throws ODTPFramwork_Renderer_Exception If $filepath is not a regular file or does not exists
     * @return ODTPFramework_Renderer_Plugin_Abstract
     */
    public function factory($filepath)
    {
        if (!is_string($filepath)) {
            throw new ODTPFramwork_Renderer_Exception('$filepath must be a string');
        }
        if (!is_file($filepath)) {
            throw new ODTPFramwork_Renderer_Exception("$filepath is not a regular file or does not exists");
        }
        $node = simplexml_load_file($filepath);
        $class_name = $this->getPluginPrefix() . ucfirst(strtolower((string)$node->server->type));

        // setting parameters for plugin instanciation
        $parameters = array(
            'id'      => (string)$node['id'],
            'type'    => (string)$node->server->type,
            'address' => (string)$node->server->address,
            'port'    => (string)$node->server->port
        );
        $renderer = new $class_name($parameters);

        return $renderer;
    }

    /**
     * Getters and setters
     */

    /**
     * Return plugin class name prefixes.
     * Default 'ODTPFramwork_Renderer_Plugin_'.
     *
     * @return string
     */
    public function getPluginPrefix()
    {
        return $this->_plugin_prefix;
    }

    /**
     * Set plugin class name prefixes.
     * Default 'ODTPFramwork_Renderer_Plugin_'.
     *
     * @param string $prefix Plugin classes prefix
     *
     * @throws ODTPFramwork_Renderer_Exception If $prefix is not a string
     * @return null
     */
    public function setPluginPrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new ODTPFramwork_Renderer_Exception('$prefix must be a string');
        }
        $this->_plugin_prefix = $prefix;
    }
}
