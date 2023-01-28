<?php

namespace tutfw\db\drivers;

use tutfw\base\DriverModel;
use tutfw\base\Model;
use tutfw\base\Response;
use tutfw\base\ResponseCode;
use tutfw\base\Trans;
use tutfw\interfaces\IModel;
use tutfw\TutFw;

/**
 * MongoDB driver
 *
 * @property string $authDatabase
 * @property \MongoDB\Client $client
 * @property string $uri
 * @property string $collection
 */
class MongoDB extends DriverModel implements IModel
{
	protected ?string $authDatabase = null;
	protected ?\MongoDB\Client $client = null;
	protected ?string $uri = 'mongodb://';
	protected ?string $collection = null;

	public function init(): void
	{
		if (!empty($this->authDatabase)) {
			$this->uri .= "{$this->user}:{$this->password}@{$this->host}:{$this->port}/{$this->authDatabase}";
		} else {
			$this->uri .= "{$this->user}:{$this->password}@{$this->host}:{$this->port}/{$this->database}";
		}
		if (!$this->client) {
			$this->client = new \MongoDB\Client($this->uri);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function customize(Model $model): void
	{
		$this->collection = $this->collection ?? $model->collection ?? null;
		$this->authDatabase = $this->authDatabase ?? $model->authDatabase ?? null;
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
	 * @param array $filter Query by which to filter documents
	 * @param array $options Command options
	 *
	 * @return integer
	 * @see CountDocuments::__construct() for supported options
	 */
	public function count(array $filter = [], array $options = []): int
	{
		try {
			return $this->getCollection()->countDocuments($filter, $options);
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Finds a single document matching the query.
	 *
	 * @see http://docs.mongodb.org/manual/core/read-operations-introduction/
	 *
	 * @param array $filter Query by which to filter documents
	 * @param array $options Additional options
	 *
	 * @return $this
	 */
	public function findOne(array $filter, array $options = []): static
	{
		try {
			$this->result = $this->getCollection()->findOne($filter, $options);
//			$this->unsetSecuredProperties();
			return $this;
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Finds documents matching the query.
	 *
	 * @see http://docs.mongodb.org/manual/core/read-operations-introduction/
	 *
	 * @param array $filter Query by which to filter documents
	 * @param array $options Additional options
	 *
	 * @return $this
	 */
	public function find(array $filter, array $options = []): static
	{
		try {
			$this->result = $this->getCollection()->find($filter, $options);
//			$this->unsetSecuredProperties();
			return $this;
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Inserts one document.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/insert/
	 *
	 * @param array $document The document to insert
	 * @param array $options Command options
	 *
	 * @return mixed inserted ID
	 */
	public function insertOne(array $document, array $options = []): mixed
	{
		try {
			$result = $this->getCollection()->insertOne($document, $options);
			return $result->getInsertedId();
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
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
	 * @return int|null inserted count
	 */
	public function insertMany(array $documents, array $options = []): ?int
	{
		try {
			$result = $this->getCollection()->insertMany($documents, $options);
			return $result->getInsertedCount();
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
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
	 * @return int|null modified count
	 */
	public function updateOne($filter, $update, array $options = []): ?int
	{
		try {
			$result = $this->getCollection()->updateOne($filter, $update, $options);
			return $result->getModifiedCount();
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
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
	 * @return int|null modified count
	 */
	public function replaceOne($filter, $update, array $options = []): ?int
	{
		try {
			$options['upsert'] = true;
			$result = $this->getCollection()->updateOne($filter, $update, $options);
			return $result->getUpsertedCount() ?: $result->getMatchedCount();
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
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
	 * @return integer|null
	 */
	public function updateMany($filter, $update, array $options = []): ?int
	{
		try {
			$result = $this->getCollection()->updateMany($filter, $update, $options);
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
		return $result->getModifiedCount();
	}

	/**
	 * Deletes at most one document matching the filter.
	 *
	 * @see http://docs.mongodb.org/manual/reference/command/delete/
	 *
	 * @param array|object $filter Query by which to delete documents
	 * @param array $options Command options
	 *
	 * @return int|null deleted count
	 */
	public function deleteOne($filter, array $options = []): ?int
	{
		try {
			$result = $this->getCollection()->deleteOne($filter, $options);
			return $result->getDeletedCount();
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
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
	 * @return int|null deleted count
	 */
	public function deleteMany($filter, array $options = []): ?int
	{
		try {
			$result = $this->getCollection()->deleteMany($filter, $options);
			return $result->getDeletedCount();
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Executes an aggregation framework pipeline on the collection.
	 *
	 * Note: this method's return value depends on the MongoDB server version
	 * and the "useCursor" option. If "useCursor" is true, a Cursor will be
	 * returned; otherwise, an ArrayIterator is returned, which wraps the
	 * "result" array from the command response document.
	 *
	 * @param array $pipeline List of pipeline operations
	 * @param array $options Command options
	 *
	 * @return \Traversable|null
	 * @see Aggregate::__construct() for supported options
	 */
	public function aggregate(array $pipeline, array $options = []): ?\Traversable
	{
		try {
			$result = $this->getCollection()->aggregate($pipeline, $options);
			return $result;
		} catch (\Exception $exception) {
			return Response::error(ResponseCode::E500, Trans::t('app', 'Failure on execute query.'), TutFw::getDebugMode($exception));
		}
	}

	/**
	 * Get returned data after executed query
	 *
	 * @return array|object|null
	 */
	public function getResult()
	{
		return $this->result;
	}
}
