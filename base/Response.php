<?php

namespace tutfw\base;

use tutfw\base\BaseObject;
use tutfw\interfaces\IResponse;

class Response extends BaseObject
{
	const STATUS_SUCCESS = 'success';
	const STATUS_WARNING = 'warning';
	const STATUS_ERROR = 'error';
	const STATUS_REDIRECT = 'redirect';
	public $code = null;
	public $status = null;
	public $message = null;
	public $data = null;

	private static function toJson(Response $response)
	{
		return json_encode($response);
	}

	private static function render($status, $data = [], $message = '', $code = 200)
	{
		http_response_code($code);
		header('Content-Type: application/json; charset=utf-8');
		echo self::toJson(new Response([
			'code' => $code,
			'message' => $message,
			'status' => $status,
			'data' => $data,
		]));
		exit;
	}

	public static function success(array $data = [], string $message = '', int $code = 200)
	{
		return self::render(self::STATUS_SUCCESS, $data, $message, $code);
	}

	public static function warning(string $message = '', array $data = [], int $code = 200)
	{
		return self::render(self::STATUS_WARNING, $data, $message, $code);
	}

	public static function error(int $code = 400, string $message = '', array $data = [])
	{
		return self::render(self::STATUS_ERROR, $data, $message, $code);
	}

	public static function redirect(array $data = [], int $code = 302, string $message = '')
	{
		return self::render(self::STATUS_REDIRECT, $data, $message, $code);
	}
}
