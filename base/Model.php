<?php


namespace tutfw\vendor\tutfw\base;


use tutfw\base\BaseObject;

class Model extends BaseObject
{
	protected $database = '';
	protected $user = '';
	protected $password = '';
	protected $uri = '';
	
	protected function connection(): self
	{
		
	}
}