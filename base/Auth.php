<?php

namespace tutfw\base;

use tutfw\interfaces\IAuthSessionDriver;
use tutfw\interfaces\IUserModel;

/**
 * @property IUserModel|null $model
 * @property string $sessionDriverClass
 * @property IAuthSessionDriver|null $sessionDriver
 * @property array $sessionDriverProperties
 * @property UserModel|false|null $user
 *
 * @author Mehdi
 */
class Auth
{
	/** @var IUserModel|null Database User Model Object */
	protected IUserModel|null $model = null;
	/** @var string Session driver class */
	protected string $sessionDriverClass = 'default';
	/** @var IAuthSessionDriver|null Session Driver Class */
	protected IAuthSessionDriver|null $sessionDriver = null;
	/** @var array Session Driver Properties */
	protected array $sessionDriverProperties = [];
	/** @var UserModel|false|null Form User Model Object */
	protected UserModel|false|null $user = null;
	/** @var string User Login Key */
	const AUTH_SESSION_KEY = 'ulk';

	/**
	 * Constructing the database user model object
	 *
	 * @param IUserModel|null $model database user model object
	 */
	public function __construct(?IUserModel $model)
	{
		$this->model = $model;
		if (session_status() == PHP_SESSION_DISABLED) {
			session_start();
		}
	}

	/**
	 * Login action by form user model object
	 * Can make Auth object with your session control and login class
	 *
	 * @param UserModel $userModel form user model object
	 *
	 * @return UserModel|null
	 * @throws \Exception
	 */
	public function login(UserModel $userModel): ?UserModel
	{
		if ($this->sessionDriverClass !== 'default') {
			if (!class_exists($this->sessionDriverClass)) {
				throw new \Exception("Session driver class not found.");
			}
			$this->sessionDriver = new ($this->sessionDriverClass)($this->sessionDriverProperties);
			if (!($this->sessionDriver instanceof IAuthSessionDriver)) {
				throw new \Exception("Session driver object is not instance of IAuthSessionDriver.");
			}
			return $this->sessionDriver->login($userModel);
		}
		return $this->userLogin($userModel);
	}

	/**
	 * User authentication checking & create user login key in session
	 *
	 * @param UserModel $userModel
	 *
	 * @return UserModel|null
	 */
	protected function userLogin(UserModel $userModel): ?UserModel
	{
		$this->user = $this->getUserFromSession();
		if (!$this->user) {
			$this->user = $this->model->getUserByUsername($userModel->getUsername());
			if (!$this->model->checkPassword($userModel->getPassword(), $this->user->getPassword())) {
				return null;
			}
			$this->setUserSession();
		}
		return $this->user;
	}

	/**
	 * Get user by session token
	 *
	 * @return UserModel|null
	 */
	protected function getUserFromSession(): ?UserModel
	{
		$token = ($_SESSION[self::AUTH_SESSION_KEY] ?? null);
		if (!$token) {
			return null;
		}
		return $this->model->getUserByToken($token);
	}

	/**
	 * Set user session key
	 *
	 * @return void
	 */
	protected function setUserSession(): void
	{
		$userLoginKey = $this->getUserSessionLoginKey();
		$_SESSION[self::AUTH_SESSION_KEY] = $userLoginKey;
	}

	/**
	 * Get user session login key
	 *
	 * @return string
	 */
	protected function getUserSessionLoginKey(): string
	{
		return $_SESSION[self::AUTH_SESSION_KEY] ?? md5($this->user->getUsername() . time() . uniqid());
	}

	/**
	 * Get user object
	 *
	 * @return UserModel|null
	 */
	public function user(): ?UserModel
	{
		return $this->getUserFromSession();
	}

	/**
	 * Get the user profile data with selectable wanted columns
	 *
	 * @param array $select
	 *
	 * @return array
	 */
	public function userProfile(array $select = []): array
	{
		return $this->model->getUserProfile($this->getId(), $select);
	}

	/**
	 * Get user ID
	 *
	 * @return string|int|null
	 */
	protected function getId(): string|int|null
	{
		return $this->getUserFromSession()->getId();
	}

}
