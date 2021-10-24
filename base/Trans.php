<?php


namespace tutfw\vendor\tutfw\base;


use tutfw\base\BaseObject;
use tutfw\base\TutFw;

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
		$filePath = "{$rootPath}/lang/" . TutFw::$fw->lang . "/{$file}.php";
		$transArray = include(file_exists($filePath) ? $filePath
			: "{$rootPath}/vendor/tutfw/lang/app.php");
		
		return $transArray[$key] ?? $key;
	}
}