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
			$job->run($args);
		} else {
			echo "Job not found :( please check command name\n";
		}
	}
}
