<?php

namespace tutfw\base;

/**
 * Object creator
 *
 * @property string $id
 * @property string $name
 * @property string $version
 * @property string $default_controller
 * @property array $params
 * @property array $urlManager
 *
 * @author Mehdi
 */
class BaseObject
{
	/**
	 * BaseObject constructor.
	 *
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		if (!empty($config)) {
			$this->configure($this, $config);
		}
		$this->init();
	}
	
	/**
	 * Make BaseObject with the config
	 *
	 * @param self $object
	 * @param array $properties
	 * @return mixed
	 */
	private function configure($object, $properties)
	{
		foreach ($properties as $name => $value) {
			$object->$name = $value;
		}
		
		return $object;
	}
	
	/**
	 * Initialize method
	 */
	public function init()
	{
		// Initialize method
	}
	
}
