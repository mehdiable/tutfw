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
	static $urlManager;
	
	/** @var array Default url manager setting */
	private static $defaultUrlManager = [
		'class' => 'tutfw\base\UrlManager',
		'default_url' => '',
		'rules' => [
//			'[regular_expression_rules]' => '<route>',
			'[|/]' => 'site/index',
		]
	];
	
	/**
	 * @param array $config
	 */
	private static function init(array $config)
	{
		if (empty(self::$fw)) {
			self::$fw = new BaseObject($config);
		}
		
		if (!isset(self::$fw->urlManager)) {
			self::$fw->urlManager = self::$defaultUrlManager;
		}
		
		if (!isset(self::$fw->urlManager['class'])) {
			self::$fw->urlManager['class'] = self::$defaultUrlManager['class'];
		}
		
		if (!isset(self::$fw->urlManager['rules'])) {
			self::$fw->urlManager['rules'] = self::$defaultUrlManager['rules'];
		}
		
		if (!isset(self::$fw->urlManager['controller'])) {
			self::$fw->urlManager['controller'] = self::$defaultUrlManager['controller'];
		}
	}
	
	/**
	 * @param array $config
	 *
	 * @todo MVC
	 * @todo route to controller -> action
	 */
	public static function run(array $config)
	{
		self::init($config);
		
		self::$urlManager = new UrlManager(self::$fw->urlManager);
		return self::$urlManager->handler();
	}
	
}
