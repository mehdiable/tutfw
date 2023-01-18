<?php

namespace tutfw\db\drivers;

use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Result;
use tutfw\base\DriverModel;
use tutfw\base\Response;
use tutfw\base\ResponseCode;
use tutfw\base\Trans;
use tutfw\interfaces\IModel;
use tutfw\TutFw;

/**
 * @property Result $result
 */
class MySQL extends DriverModel implements IModel
{
	protected ?\Doctrine\DBAL\Connection $conn = null;

	public function init()
	{
		if (!$this->conn) {
			$connectionParams = [
				'dbname' => $this->database,
				'user' => $this->user,
				'password' => $this->password,
				'host' => $this->host,
				'driver' => 'pdo_mysql',
			];
			$this->conn = DriverManager::getConnection($connectionParams);
		}
	}

	public function query(string $sql, array $params = [], $types = [], ?QueryCacheProfile $qcp = null): static
	{
		try {
			$this->result = $this->conn->executeQuery($sql, $params, $types, $qcp);
			return $this;
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	public function all()
	{
		return $this->result->fetchAllAssociative();
	}

	public function one()
	{
		return $this->result->fetchAssociative();
	}
}
