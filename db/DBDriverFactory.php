<?php

namespace tutfw\db;

use tutfw\interfaces\IModel;

class DBDriverFactory
{
	const SUPPORT_DRIVERS = [
		'mongodb' => 'MongoDB',
		'mysql' => 'MySQL',
		'mariadb' => 'MariaDB'
	];
	const DEFAULT_DRIVER = 'mongodb';
	protected IModel|null $driver = null;

	/**
	 * @param string $driver It will to lowercase
	 *
	 * @throws ExceptionDBDriver
	 */
	public function __construct(string $driver = self::DEFAULT_DRIVER, array $params = [])
	{
		$driver = strtolower($driver);
		$this->isThrowable($driver);
		$driverPath = "\\tutfw\\db\\drivers\\" . self::SUPPORT_DRIVERS[$driver];
		$this->driver = new $driverPath($params);
	}

	/**
	 * @param string $driver
	 *
	 * @return void
	 * @throws ExceptionDBDriver
	 */
	private function isThrowable(string $driver): void
	{
		if (empty($driver)) {
			throw new ExceptionDBDriver("Driver couldn't be empty.");
		}

		if (!in_array($driver, array_keys(self::SUPPORT_DRIVERS))) {
			throw new ExceptionDBDriver("Sorry, your '{$driver}' driver couldn't support in this version of framework. You could be adding new driver to 'TutFW' project, we will be happy :).");
		}
	}

	/**
	 * Get DB driver object
	 *
	 * @return IModel
	 */
	public function getDriver(): IModel
	{
		return $this->driver;
	}
}
