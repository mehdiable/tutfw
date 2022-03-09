<?php


namespace tutfw\base;


use tutfw\TutFw;

class Log
{
	private static function set(string $message, array $data = [], string $logTitle = ''): false|int
	{
		$rootPath = TutFw::getRootPath();
		$filePath = "{$rootPath}/logs/{$logTitle}.log";
		$_data = implode("\n", $data);
		$f = fopen($filePath, "a");
		$now = date('Y-m-d H:i:s');
		$result = fwrite($f, "{$logTitle} : ------ date : {$now} ------------" .
			"\n{$message}" .
			(!empty($_data) ? "\n{$_data}" : '') .
			"\n------------------------\n\n");
		fclose($f);

		return $result;
	}

	public static function error(string $message, array $data = []): false|int
	{
		return self::set($message, $data, 'ERROR');
	}

	public static function warning(string $message, array $data = []): false|int
	{
		return self::set($message, $data, 'WARNING');
	}

	public static function info(string $message, array $data = []): false|int
	{
		return self::set($message, $data, 'INFO');
	}
}
