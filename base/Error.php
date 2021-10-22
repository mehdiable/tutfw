<?php


namespace tutfw\vendor\tutfw\base;


use tutfw\base\BaseObject;

class Error extends BaseObject
{
	public $code = null;
	public $message = null;
	
	public static function page(int $code, string $message): View
	{
		
	}
}