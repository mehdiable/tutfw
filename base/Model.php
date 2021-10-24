<?php


namespace tutfw\vendor\tutfw\base;


use tutfw\base\BaseObject;
use tutfw\base\TutFw;

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
		$db = include_once TutFw::getRootPath() . '/conf/db.php';
		parent::__construct($db);
	}
	
	public function init()
	{
		$this->uri .= "{$this->user}:{$this->password}@{$this->host}:{$this->port}/{$this->database}";
		
		$this->client = new \MongoDB\Client($this->uri);
		$this->getCollection();
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
	 * Finds a single document matching the query.
	 *
	 * @see http://docs.mongodb.org/manual/core/read-operations-introduction/
	 * @param array|object $filter Query by which to filter documents
	 * @param array $options Additional options
	 * @return array|object|null
	 */
	public function findOne(array $filter, array $options = [])
	{
		return $this->getCollection()->findOne($filter, $options);
	}
	
	/**
	 * Finds documents matching the query.
	 *
	 * @see http://docs.mongodb.org/manual/core/read-operations-introduction/
	 * @param array|object $filter Query by which to filter documents
	 * @param array $options Additional options
	 * @return Cursor
	 */
	public function find(array $filter, array $options = [])
	{
		return $this->getCollection()->find($filter, $options);
	}
	
	/**
	 * Inserts one document.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/insert/
	 * @param array|object $document The document to insert
	 * @param array $options Command options
	 * @return \MongoDB\BSON\OBjectId inserted ID
	 */
	public function insertOne(array $document, array $options = [])
	{
		$result = $this->getCollection()->insertOne($document, $options);
		return $result->getInsertedId();
	}
	
	/**
	 * Inserts multiple documents.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/insert/
	 * @param array[]|object[] $documents The documents to insert
	 * @param array $options Command options
	 * @return int inserted count
	 */
	public function insertMany(array $documents, array $options = [])
	{
		$result = $this->getCollection()->insertMany($documents, $options);
		return $result->getInsertedCount();
	}
	
	/**
	 * Updates at most one document matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/update/
	 * @param array|object $filter Query by which to filter documents
	 * @param array|object $update Update to apply to the matched document
	 * @param array $options Command options
	 * @return int modified count
	 */
	public function updateOne($filter, $update, array $options = [])
	{
		$result = $this->getCollection()->updateOne($filter, $update, $options);
		return $result->getModifiedCount();
	}
	
	/**
	 * Updates all documents matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/update/
	 * @param array|object $filter Query by which to filter documents
	 * @param array|object $update Update to apply to the matched documents
	 * @param array $options Command options
	 * @return UpdateResult
	 */
	public function updateMany($filter, $update, array $options = [])
	{
		$result = $this->getCollection()->updateMany($filter, $update, $options);
		return $result->getModifiedCount();
	}
	
	/**
	 * Deletes at most one document matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/delete/
	 * @param array|object $filter Query by which to delete documents
	 * @param array $options Command options
	 * @return int deleted count
	 */
	public function deleteOne($filter, array $options = [])
	{
		$result = $this->getCollection()->deleteOne($filter, $options);
		return $result->getDeletedCount();
	}
	
	/**
	 * Deletes all documents matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/delete/
	 * @param array|object $filter Query by which to delete documents
	 * @param array $options Command options
	 * @return int deleted count
	 */
	public function deleteMany($filter, array $options = [])
	{
		$result = $this->getCollection()->deleteMany($filter, $options);
		return $result->getDeletedCount();
	}
}