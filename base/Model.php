<?php

namespace tutfw\base;

use tutfw\TutFw;

/**
 * Class Model
 *
 * @property string $database
 * @property string $collection
 * @property string $user
 * @property string $password
 * @property string $host
 * @property string $port
 * @property string $uri
 * @property \MongoDB\Client $client
 *
 * @package tutfw\vendor\tutfw\base
 */
class Model extends BaseObject
{
	protected $database = null;
	protected $collection = null;
	protected $user = null;
	protected $password = null;
	protected $host = null;
	protected $port = null;
	private $uri = 'mongodb://';
	protected $client = null;

	public function __construct()
	{
		$db = include TutFw::getRootPath() . '/conf/db.php';
		parent::__construct($db);
	}

	public static function ins()
	{
//		return instance
	}

	public function init()
	{
		$this->uri .= "{$this->user}:{$this->password}@{$this->host}:{$this->port}/{$this->database}";
		if (!$this->client) {
			$this->client = new \MongoDB\Client($this->uri);
		}
	}

	/**
	 * @return \MongoDB\Collection
	 */
	public function getCollection()
	{
		$collection = $this->collection;
		$database = $this->database;
		return $this->client->$database->$collection;
	}

	/**
	 * Gets the number of documents matching the filter.
	 *
	 * @param array|object $filter Query by which to filter documents
	 * @param array $options Command options
	 *
	 * @return integer
	 * @see CountDocuments::__construct() for supported options
	 */
	public function count(array $filter, array $options = [])
	{
		try {
			return $this->getCollection()->countDocuments($filter, $options);
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Finds a single document matching the query.
	 *
	 * @see http://docs.mongodb.org/manual/core/read-operations-introduction/
	 *
	 * @param array|object $filter Query by which to filter documents
	 * @param array $options Additional options
	 *
	 * @return array|object|null
	 */
	public function findOne(array $filter, array $options = [])
	{
		try {
			return $this->getCollection()->findOne($filter, $options);
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Finds documents matching the query.
	 *
	 * @see http://docs.mongodb.org/manual/core/read-operations-introduction/
	 *
	 * @param array|object $filter Query by which to filter documents
	 * @param array $options Additional options
	 *
	 * @return \MongoDB\Driver\Cursor
	 */
	public function find(array $filter, array $options = [])
	{
		try {
			return $this->getCollection()->find($filter, $options);
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Inserts one document.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/insert/
	 *
	 * @param array|object $document The document to insert
	 * @param array $options Command options
	 *
	 * @return \MongoDB\BSON\OBjectId inserted ID
	 */
	public function insertOne(array $document, array $options = [])
	{
		try {
			$result = $this->getCollection()->insertOne($document, $options);
			return $result->getInsertedId();
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Inserts multiple documents.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/insert/
	 *
	 * @param array[]|object[] $documents The documents to insert
	 * @param array $options Command options
	 *
	 * @return int inserted count
	 */
	public function insertMany(array $documents, array $options = [])
	{
		try {
			$result = $this->getCollection()->insertMany($documents, $options);
			return $result->getInsertedCount();
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Updates at most one document matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/update/
	 *
	 * @param array|object $filter Query by which to filter documents
	 * @param array|object $update Update to apply to the matched document
	 * @param array $options Command options
	 *
	 * @return int modified count
	 */
	public function updateOne($filter, $update, array $options = [])
	{
		try {
			$result = $this->getCollection()->updateOne($filter, $update, $options);
			return $result->getModifiedCount();
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Updates all documents matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/update/
	 *
	 * @param array|object $filter Query by which to filter documents
	 * @param array|object $update Update to apply to the matched documents
	 * @param array $options Command options
	 *
	 * @return UpdateResult
	 */
	public function updateMany($filter, $update, array $options = [])
	{
		try {
			$result = $this->getCollection()->updateMany($filter, $update, $options);
			return $result->getModifiedCount();
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Deletes at most one document matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/delete/
	 *
	 * @param array|object $filter Query by which to delete documents
	 * @param array $options Command options
	 *
	 * @return int deleted count
	 */
	public function deleteOne($filter, array $options = [])
	{
		try {
			$result = $this->getCollection()->deleteOne($filter, $options);
			return $result->getDeletedCount();
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Deletes all documents matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/delete/
	 *
	 * @param array|object $filter Query by which to delete documents
	 * @param array $options Command options
	 *
	 * @return int deleted count
	 */
	public function deleteMany($filter, array $options = [])
	{
		try {
			$result = $this->getCollection()->deleteMany($filter, $options);
			return $result->getDeletedCount();
		} catch (\Exception $exception) {
			Response::error(500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}
}
