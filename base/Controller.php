<?php


namespace tutfw\vendor\tutfw\base;


class Controller
{
	public function __construct($action)
	{
		$this->beforeActions();
		$this->$action();
		$this->afterActions();
	}
	
	public function beforeActions()
	{
	}
	
	public function afterActions()
	{
	}
}