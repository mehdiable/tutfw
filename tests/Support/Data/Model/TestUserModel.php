<?php

namespace Tests\Support\Data\Model;

use tutfw\base\UserModel;
use tutfw\interfaces\IUserModel;

class TestUserModel implements IUserModel
{

	public function getUserProfile(string $userId, ?array $select = null): array
	{
		return [
			'id' => $userId,
			'connector' => '09126440679',
			'first_name' => 'Mehdi',
			'last_name' => 'Mohammadnejad',
			'national_code' => '0123456789',
			'mobile' => '09126440679',
			'email' => 'mohammadnejad.job@gmail.com',
			'avatar' => '/storage/image/avatar.png',
			'father_name' => 'Sayad',
			'birthday' => '1986-10-09',
		];
	}

	public function getUserByUsername(string $username): UserModel|false|null
	{
		$user = [
			'09126440679' => [
				'id' => 1,
				'username' => $username,
				'password' => crypt('123456', 'salt'),
				'full_name' => 'Mehdi Mohammadnejad',
			]
		];
		return new UserModel($user[$username] ?? []);
	}

	public function checkPassword(string $password, string $hashedPassword): bool
	{
		return crypt($password, 'salt');
	}

	public function getUserByToken(string $token): UserModel|false|null
	{
		return new UserModel([
			'id' => 1,
			'username' => '09126440679',
			'password' => crypt('123456', 'salt'),
			'full_name' => 'Mehdi Mohammadnejad',
		]);
	}
}
