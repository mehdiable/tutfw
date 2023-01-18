<?php

namespace tutfw\base;

use tutfw\db\DBDriverFactory;
use tutfw\db\drivers\MongoDB;
use tutfw\db\drivers\MySQL;
use tutfw\db\ExceptionDBDriver;
use tutfw\interfaces\IModel;
use tutfw\TutFw;

/**
 * Class Model
 *
 *
 * @package tutfw\base
 */
class Model
{
	protected string $driver = DBDriverFactory::DEFAULT_DRIVER;
	protected IModel|null $driverObj = null;
	protected string $connection = 'default';

	/**
	 * @throws ExceptionDBDriver
	 */
	public function __construct(?array $db = null)
	{
		if (!$db) {
			$db = include TutFw::getRootPath() . '/conf/db.php';
		}
		$this->driver($db[$this->connection] ?? []);
	}

	/**
	 * Get new instance of the model
	 *
	 * @return static
	 */
	public static function ins(): static
	{
		return new static();
	}

	/**
	 * @param array $params
	 *
	 * @return IModel|MongoDB|MySQL
	 * @throws ExceptionDBDriver
	 */
	public function driver(array $params = []): IModel|MongoDB|MySQL
	{
		if ($this->driverObj) {
			return $this->driverObj;
		}
		$this->driver = $params['driver'] ?? $this->driver;
		$driver = new DBDriverFactory($this->driver, $params);
		$this->driverObj = $driver->getDriver();
		return $this->driverObj;
	}

	/**
	 * Unset the secured data from the object
	 *
	 * @return void
	 */
	private function unsetSecuredProperties(): void
	{
		unset($this->database, $this->collection, $this->user, $this->password,
			$this->host, $this->port, $this->uri, $this->client);
	}
}
