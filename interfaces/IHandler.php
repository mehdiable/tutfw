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
	 * @param array|null $data
	 * @see \tutfw\base\Response::error()
	 *
	 * response as string of JSON
	 * @see \tutfw\base\Response::success()
	 */
	public function handler(array $data = null);
}
