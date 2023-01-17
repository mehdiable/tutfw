<?php

namespace tutfw\interfaces;

use tutfw\base\UserModel;

/**
 * User model concept for using in Auth class features
 */
interface IUserModel
{
	/**
	 * Get user profile data
	 *
	 * @param string $userId
	 * @param array|null $select
	 *
	 * @return array
	 */
	public function getUserProfile(string $userId, ?array $select = null): array;

	/**
	 * Get user model object by username
	 *
	 * @param string $username
	 *
	 * @return UserModel|false|null
	 */
	public function getUserByUsername(string $username): UserModel|false|null;

	/**
	 * Get user by token
	 *
	 * @param string $token
	 *
	 * @return UserModel|false|null
	 */
	public function getUserByToken(string $token): UserModel|false|null;

	/**
	 * Get password hash. Make password hash by your security hashing method.
	 *
	 * @param string $password
	 *
	 * @return string
	 */
	public function getPasswordHash(string $password): string;
}
