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
	public array $dynamicProperty = [];
	
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
	protected function configure($object, $properties)
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

	public function &__get(string $name)
	{
		if (!isset($this->dynamicProperty[$name])) {
			$this->dynamicProperty[$name] = null;
		}
		return $this->dynamicProperty[$name];
	}

	public function __set(string $name, $value): void
	{
		$this->dynamicProperty[$name] = $value;
	}

	public function __isset(string $name): bool
	{
		return isset($this->dynamicProperty[$name]);
	}

}
