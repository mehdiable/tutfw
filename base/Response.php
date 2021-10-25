<?php


namespace tutfw\base;


use tutfw\base\BaseObject;

class Response extends BaseObject
{
	const STATUS_SUCCESS = 'success';
	const STATUS_ERROR = 'error';
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
	
	public static function success($data = [], $message = '', $code = 200)
	{
		return self::render(self::STATUS_SUCCESS, $data, $message, $code);
	}
	
	public static function error($code = 400, $message = '', $data = [])
	{
		return self::render(self::STATUS_ERROR, $data, $message, $code);
	}
}