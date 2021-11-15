<?php

namespace tutfw;

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
			self::$fw = new base\BaseObject($config);
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
	 */
	public static function run(array $config)
	{
		if (defined('debug')) {
			ini_set('xdebug.var_display_max_depth', 7);
			ini_set('xdebug.var_display_max_children', 256);
			ini_set('xdebug.var_display_max_data', 1024);
			error_reporting(E_ALL);
		}
		self::init($config);
		self::$urlManager = new base\UrlManager(self::$fw->urlManager);
		return self::$urlManager->handle();
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
	 *
	 * @return string|null
	 */
	public static function ucWords(string $words, $pattern = '-_'): ?string
	{
		return preg_replace("/[$pattern]/", '', ucwords($words, $pattern));
	}

	/**
	 * Get debug mode data when it is active
	 *
	 * @param \Exception $exception
	 *
	 * @return array|\Exception
	 */
	public static function getDebugMode(\Exception $exception): \Exception|array
	{
		return defined('debug') ? [
			'code' => $exception->getCode(),
			'message' => $exception->getMessage(),
			'line' => $exception->getLine(),
			'file' => $exception->getFile(),
			'trace' => $exception->getTrace(),
		] : [];
	}

	/**
	 * Get patch params of request, when request method is PATCH
	 *
	 * @return array
	 *
	 * @TODO : set patch method ... when complete on server remove POST, else uncomment POST
	 */
	public static function getPatchParams(): array
	{
		return $_POST ?? [];

//		mb_parse_str(file_get_contents('php://input'), $_PATCH);
//		return $_PATCH;
	}

}
