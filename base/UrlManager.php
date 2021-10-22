<?php

namespace tutfw\base;


use tutfw\vendor\tutfw\base\Url;

/**
 * UrlManager
 *
 * @property string $class
 * @property string $controller
 * @property string $rules
 * @property Url $url
 *
 * @author mm
 */
class UrlManager extends BaseObject
{
	public $class = 'tutfw\base\UrlManager';
	public $controller = '';
	public $rules = [];
	
	/** @var Url */
	public $url = null;
	
	
	public function handler(): IView
	{
		$this->makeUrl();
		$this->parsePrettyUrlPath();
		$this->callController();
	}
	
	public function makeUrl(): void
	{
		$url = [
			'schema' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"),
			'host' => $_SERVER['HTTP_HOST'],
			'path' => $_SERVER['REQUEST_URI'],
		];
		
		$this->url = new Url($url);
	}
	
	protected function callController()
	{
//		if (preg_match(null, $this->rules)) {
//
//		}
		$this->controller;
	}
	
	protected function parsePrettyUrlPath()
	{
		if ($this->url->path) {
			$path = preg_replace('/\//', '', $this->url->path, 1);
			
			if (!isset($this->rules[$path])) {
				Error::page(404, 'Not found page');
			}
			var_dump($this->rules[$path]);
			
			$this->url->setController();
			$this->url->setAction();
		}
	}
}
