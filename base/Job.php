<?php

namespace tutfw\base;

/**
 * Class Job
 * @package tutfw\base
 */
class Job
{
	public function __construct(string $command, ?array $args = null)
	{
		$_SERVER['DOCUMENT_ROOT'] = $_SERVER['PWD'];
		$class = strtr(ucwords($command, ':'), [':' => '']) . 'Job';
		if (class_exists("\\tutfw\\job\\" . $class)) {
			$jobClass = "\\tutfw\\job\\" . $class;
			$job = new $jobClass();
			if (!method_exists($job, 'run')) {
				echo "The run method is not defined\n";
				exit;
			}
			$this->updateParams($job, $args);
			$job->run($args);
		} else {
			echo "Job not found :( please check command name\n";
		}
	}

	/**
	 * Cast arguments to array
	 *
	 * @param $args
	 */
	private function updateParams($job, &$args): void
	{
		$_params = [];
		foreach ($args as $param) {
			if (isset($job->args)) {
				foreach ($job->args as $arg) {
					if (preg_match("/{$arg}/i", $param, $matches)) {
						$_params[strtr($arg, ['--' => '', '=' => ''])] = strtr($param, [$arg => '']);
					}
				}
			}
		}
		$args = $_params;
	}

}
