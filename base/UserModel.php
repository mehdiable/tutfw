<?php

namespace tutfw\base;

/**
 * Set user model object to be using the user as the login form or database user model object
 */
class UserModel extends BaseObject
{
	protected string|int|null $id = null;
	protected string|null $username = null;
	protected string|null $password = null;
	protected string|null $fullName = null;
	protected array|null $profile = null;

	/**
	 * Get username
	 *
	 * @return string|null
	 */
	public function getUsername(): ?string
	{
		return $this->username;
	}

	/**
	 * Get password
	 *
	 * @return string|null
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}

	/**
	 * Get user ID
	 *
	 * @return string|int|null
	 */
	public function getId(): string|int|null
	{
		return $this->id;
	}

	/**
	 * Get user profile data
	 *
	 * @return array|null
	 */
	public function getProfile(): ?array
	{
		return $this->profile;
	}

	/**
	 * Get full name (first name by last name)
	 *
	 * @return string|null
	 */
	public function getFullName(): ?string
	{
		return $this->fullName;
	}

}
