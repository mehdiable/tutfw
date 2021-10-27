<?php

namespace tutfw\interfaces;

interface IResponse
{
	public static function success(array $data, string $message = '', int $code = 200);
	public static function error(int $code = 400, string $message = '', array $data = []);
}
