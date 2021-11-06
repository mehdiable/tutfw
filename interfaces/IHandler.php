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
	 *  tutfw\base\Response::error(HTTP_RESPONSE_CODE = 40x, 'Message text', [
	 *      'key' => $mixed_value
	 *  ]);
	 * ```
	 * @param array|null $data
	 * @see \tutfw\base\Response::error()
	 *
	 * response as string of JSON
	 * @see \tutfw\base\Response::success()
	 */
	public function handle(array $data = null);
}
