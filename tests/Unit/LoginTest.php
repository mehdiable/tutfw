<?php

namespace Unit;

use \Tests\Support\Data\Model\TestUserModel;
use Tests\Support\UnitTester;
use tutfw\base\Auth;
use tutfw\base\UserModel;

class LoginTest extends \Codeception\Test\Unit
{
	protected UnitTester $tester;

	protected function _before()
	{
		$_SERVER['HTTP_HOST'] = 'lms.local';
	}

	public function testLogin()
	{
		$auth = new Auth(new TestUserModel());
		$userModel = new UserModel([
			'username' => '09126440679',
			'password' => '123456',
		]);

		$user = $auth->login($userModel);
		$this->assertInstanceOf(UserModel::class, $user);
	}

	public function testLoginFailedWrongPassword()
	{
		$auth = new Auth(new TestUserModel());
		$userModel = new UserModel([
			'username' => '09126440679',
			'password' => '12345',
		]);

		$user = $auth->login($userModel);
		$this->assertNotInstanceOf(UserModel::class, $user);
	}

	public function testLoginFailedWrongUsername()
	{
		$auth = new Auth(new TestUserModel());
		$userModel = new UserModel([
			'username' => '0912644679',
			'password' => '123456',
		]);

		$user = $auth->login($userModel);
		$this->assertNotInstanceOf(UserModel::class, $user);
	}
}
