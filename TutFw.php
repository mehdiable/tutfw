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
		'controller' => 'site/index',
		'rules' => []
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
		if (defined('debug')) {
			error_reporting(E_ALL);
		}
		self::init($config);
		self::$urlManager = new UrlManager(self::$fw->urlManager);
		return self::$urlManager->handler();
	}
	
	/**
	 * Get root path
	 *
	 * @return mixed
	 */
	public static function getRootPath()
	{
		return strtr($_SERVER['DOCUMENT_ROOT'], ['/web' => '']);
	}
	
	/**
	 * Get the upper case of words with pattern
	 *
	 * @param string $words
	 * @param string $pattern
	 * @return string|null
	 */
	public static function ucWords(string $words, $pattern = '-_'): ?string {
		return preg_replace("/[$pattern]/", '', ucwords($words, $pattern));
	}
	
}
