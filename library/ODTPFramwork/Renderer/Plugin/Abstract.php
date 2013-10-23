<?php

/**
* Abstract classes for renderer plugins
*/
class ODTPFramwork_Renderer_Plugin_Abstract implements ODTPFramwork_Renderer_Plugin_Interface
{
	private $_id = '';
	private $_type = '';

	/**
	 * Default plugin constructor. Should not be overloaded.
	 * Prefer to overload _init() instead.
	 *
	 * @param array $parameters Renderer configurations
	 * @throws ODTPFramwork_Renderer_Exception If $parameters is not an array
	 */
	public function __construct($parameters = null) {
		if (!is_null($parameters) && !is_array($parameters)) {
			throw new ODTPFramwork_Renderer_Exception('$parameters must be an array');
		}
		$this->_init($parameters);
	}

	/**
	 * Overloadable function for plugin initialisation.
	 *
	 * @param array $node Main node contaning renderer configurations
	 * @throws ODTPFramwork_Renderer_Exception If $parameters is not an array
	 * @return null
	 */
	protected function _init($parameters)
	{
		if (!is_null($parameters) && !is_array($parameters)) {
			throw new ODTPFramwork_Renderer_Exception('$parameters must be an array');
		}
		$this->setId($parameters['id']);
		$this->_type = $parameters['type'];
	}

	/**
	 * This method must be implemented by specialized renderer class
	 *
	 * @param  ODTPFramwork_Renderer_Query_Interface $query The query to send to renderer
	 * @return ODTPFramwork_Renderer_Response_Interface
	 */
	public function query(ODTPFramwork_Renderer_Query_Interface $query) {
		throw new ODTPFramwork_Renderer_Exception("This method must be implemented");
	}

	/**
	 * Getters and setters
	 */

	/**
	 * Return plugin ID
	 *
	 * @return string
	 */
	public function getId() { return $this->_id; }

	/**
	 * Renderer type
	 *
	 * @return string
	 */
	public function getType() { return $this->_type; }

	/**
	 * Set plugin ID
	 *
	 * @throws ODTPFramwork_Renderer_Exception If $id is not a string
	 * @param string $id
	 * @return null
	 */
	public function setId($id)
	{
		if (!is_string($id)) {
			throw new ODTPFramwork_Renderer_Exception('$id must be a string');
		}
		$this->_id = $id;
	}

	/**
	 * Set plugin type
	 *
	 * @throws ODTPFramwork_Renderer_Exception If $type is not a string
	 * @param string $type
	 * @return null
	 */
	public function setType($type)
	{
		if (!is_string($type)) {
			throw new ODTPFramwork_Renderer_Exception('$type must be a string');
		}
		$this->_type = $type;
	}
}
