<?php

namespace tutfw\interfaces;

interface IHandler
{
	/**
	 * For response, use below command
	 * ```
	 *  tutfw\base\Response::success([
	 *      'key' => $mixed_value
	 *  ], 'Message text', HTTP_RESPONSE_CODE = 20x);
	 *
	 *  tutfw\base\Response::error([
	 *      'key' => $mixed_value
	 *  ], 'Message text', HTTP_RESPONSE_CODE = 40x);
	 * ```
	 * @see \tutfw\base\Response::success()
	 * @see \tutfw\base\Response::error()
	 *
	 * response as string of JSON
	 */
	public function handler(mixed $data = null);
}
