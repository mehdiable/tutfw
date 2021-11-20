<?php


namespace tutfw\base;


use tutfw\base\BaseObject;
use tutfw\TutFw;

class Trans extends BaseObject
{
	public static $lang = '';

	/**
	 * Translate
	 *
	 * @param $file
	 * @param $key
	 * @param array $params
	 * @return mixed
	 */
	public static function t($file, $key, $params = [])
	{
		$rootPath = TutFw::getRootPath();
		$lang = (isset(TutFw::$fw->lang) ? TutFw::$fw->lang . '/' : '');
		$filePath = "{$rootPath}/lang/{$lang}{$file}.php";
		$transArray = include(file_exists($filePath) ? $filePath
			: "{$rootPath}/vendor/tutfw/lang/app.php");

		if (($translated = $transArray[$key] ?? $key) && !empty($params)) {
			$translated = strtr($translated, $params);
		}

		return $translated;
	}
}
