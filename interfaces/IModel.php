<?php

namespace tutfw\interfaces;

use tutfw\base\Model;

/**
 * DB driver object maker rules
 */
interface IModel
{
	/**
	 * Initiate the driver
	 *
	 * @return void
	 */
	public function init(): void;

	/**
	 * Set model object properties to driver
	 *
	 * @param Model $model
	 *
	 * @return void
	 */
	public function customize(Model $model): void;
}
