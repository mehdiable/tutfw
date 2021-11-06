<?php

namespace tutfw\base;


use tutfw\TutFw;

/**
 * UrlManager
 *
 * @property string $class
 * @property string $route
 * @property string $rules
 * @property Url $url
 *
 * @author mm
 */
class UrlManager extends BaseObject
{
	public $class = 'tutfw\base\UrlManager';
	public $route = 'site/index';
	public $rules = [];

	/** @var Url */
	public $url = null;

	public function handle()
	{
		$this->makeUrl();
		$this->parsePrettyUrlPath();
		$this->callController();
	}

	public function makeUrl(): void
	{
		$path = parse_url($_SERVER['REQUEST_URI']);
		$url = [
			'schema' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"),
			'host' => $_SERVER['HTTP_HOST'],
			'path' => $path['path'],
		];

		$this->url = new Url($url);
	}

	protected function callController()
	{
		$controllerName = TutFw::ucwords($this->url->getController()) . 'Controller';
		$controllerNamespace = "\\tutfw\\controllers\\$controllerName";

		if (!class_exists($controllerNamespace)) {
			Response::error(ResponseCode::E404, Trans::t('app', 'not_found_controller'));
		}

		$controller = new $controllerNamespace();
		$action = $this->url->getAction() . 'Action';
		if (!method_exists($controller, $action)) {
			Response::error(ResponseCode::E404, Trans::t('app', 'not_found_action'));
		}

		if (method_exists($controller, 'beforeAction')) {
			$controller->beforeAction();
		}

		$controller->$action();

		if (method_exists($controller, 'afterAction')) {
			$controller->afterAction();
		}
	}

	protected function parsePrettyUrlPath()
	{
		if ($this->url->path) {
			$path = preg_replace('/\//', '', $this->url->path, 1);

			if (!empty($path)) {
				if (!isset($this->rules[$path])) {
					Response::error(ResponseCode::E404, Trans::t('app', 'not_found'));
				}
				$this->route = $this->rules[$path];
			}

			$this->parseRoute();
		}
	}

	/**
	 * Parse route and update url object
	 */
	protected function parseRoute(): void
	{
		if (!isset($this->route) || empty($this->route)) {
			Response::error(ResponseCode::E400, Trans::t('app', 'bad_request_route'));
		}

		$sepRoute = explode('/', $this->route);

		if (count($sepRoute) < 2 || count($sepRoute) > 2) {
			Response::error(ResponseCode::E400, Trans::t('app', 'bad_request_route'));
		}

		$this->url->setController($sepRoute[0]);
		$this->url->setAction(end($sepRoute));
	}
}
