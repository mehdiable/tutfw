<?php

namespace tutfw\base;

/**
 * Global class for run the project
 */
class TutFw
{
	/** @var BaseObject */
	static $fw;
	/** @var UrlManager */
	static $router;
	
	public function __construct(array $config)
	{
		if (empty(self::$fw)) {
			self::$fw = new BaseObject($config);
		}
	}
	
	/**
	 * @throws \Exception
	 * @todo MVC
	 * @todo route to module -> controller -> action
	 */
	public function run()
	{
		if (!isset(self::$fw->urlManager)) {
			throw new \Exception('UrlManager is not defined.');
		}
		
		if (!isset(self::$fw->urlManager['class'])) {
			throw new \Exception('UrlManager class index is not defined.');
		}
		
		self::$router = new self::$fw->urlManager['class']();
		self::$router->getRoute();
	}
	
}
