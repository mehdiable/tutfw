<?php


namespace tutfw\vendor\tutfw\base;


use tutfw\base\BaseObject;

/**
 * Class Url
 *
 * @property string $schema
 * @property string $host
 * @property string $path
 *
 * @package tutfw\vendor\tutfw\base
 */
class Url extends BaseObject
{
	public $schema = '';
	public $host = '';
	public $path = '';
	
	protected $controller = 'main';
	protected $action = 'index';
	
	
	public function __construct(array $config)
	{
		parent::__construct($config);
	}
	
	public function setController()
	{
		if (!empty($this->path)) {
			
		}
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function setAction()
	{
	
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function getSchema()
	{
		return $this->schema;
	}
	
	public function getHost()
	{
		return $this->host;
	}
	
	public function getPath()
	{
		return $this->path;
	}
	
	public function getUrl()
	{
		return $this->getSchema() . "://" . $this->getHost() . $this->getPath();
	}
}