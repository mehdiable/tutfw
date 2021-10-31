<?php

namespace tutfw\base;

use tutfw\interfaces\IJob;

/**
 * Class Job
 * @package tutfw\base
 */
class Job implements IJob
{
	/**
	 * Run job
	 */
	public function run()
	{
		echo 'you must be override this method';
	}
}

