<?php

namespace Unit;

use Tests\Support\UnitTester;
use tutfw\base\Model;

class ModelTest extends \Codeception\Test\Unit
{
	protected UnitTester $tester;
	protected Model $mysqlModel;
	protected Model $mongodbModel;

	protected function _before()
	{
		$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../..';
		$this->mongodbModel = new Model([
			'default' => [
				'authDatabase' => 'admin',
				'driver' => 'mongodb',
				'database' => 'tutfw',
				'collection' => 'tutfw_collection',
				'user' => 'tutfw_user',
				'password' => 'tutfw_password',
				'host' => '127.0.0.1',
				'port' => '27017',
			]
		]);
		$this->mysqlModel = new Model([
			'default' => [
				'driver' => 'mysql',
				'database' => 'tutfw',
				'user' => 'tutfw_user',
				'password' => 'tutfw_password',
				'host' => '127.0.0.1',
				'port' => '3306'
			]
		]);
	}

	public function testModelFind()
	{
		$sql = "select * from users limit 1";
		$dataMysqlModel = $this->mysqlModel->driver()->query($sql)->one();
		$this->assertIsArray($dataMysqlModel);

		$dataMongoModel = $this->mongodbModel->driver()->findOne([])->getResult();
		$this->assertInstanceOf(\MongoDB\Model\BSONDocument::class, $dataMongoModel);
		$this->assertIsArray($dataMongoModel->getArrayCopy());
	}

	public function testModelInsert()
	{
		// @todo : add insert sample
	}

	public function testModelUpdate()
	{
		// @todo : add update sample
	}

	public function testModelDelete()
	{
		// @todo : add delete sample
	}
}
