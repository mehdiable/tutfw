<?php

namespace tutfw\interfaces;

/**
 * DB driver object maker rules
 */
interface IModel
{
	/**
	 * Initiate the driver
	 *
	 * @return mixed
	 */
	public function init();
}
