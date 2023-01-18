<?php

namespace tutfw\base;

/**
 *
 * @property string $database
 * @property string $user
 * @property string $password
 * @property string $host
 * @property string $port
 * @property array|null|object $result
 */
class DriverModel extends BaseObject
{
	protected ?string $database = null;
	protected ?string $user = null;
	protected ?string $password = null;
	protected ?string $host = null;
	protected ?int $port = null;
	protected array|null|object $result = null;
}
