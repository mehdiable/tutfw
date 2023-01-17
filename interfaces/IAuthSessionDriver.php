<?php

namespace tutfw\interfaces;

use tutfw\base\UserModel;

/**
 * Auth session driver for customization authentication
 */
interface IAuthSessionDriver extends IUserModel
{
	/**
	 * For using Auth class features
	 *
	 * @param UserModel $params
	 *
	 * @return UserModel|null
	 */
	public function login(UserModel $params): ?UserModel;
}
