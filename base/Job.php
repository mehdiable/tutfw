<?php

namespace tutfw\base;

/**
 * Class Job
 * @package tutfw\base
 */
class Job
{
	public function __construct(string $command)
	{
		$class = strtr(ucwords($command, ':'), [':' => '']) . 'Job';
		if (class_exists("\\tutfw\\job\\" . $class)) {
			$jobClass = "\\tutfw\\job\\" . $class;
			$job = new $jobClass();
			$job->run();
		} else {
			echo 'Job not found :( please check command name';
		}
	}
	
	/**
	 * Run job
	 */
	public function run()
	{
		echo 'must be override this method';
	}
}