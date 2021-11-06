<?php

namespace tutfw\interfaces;

interface IMiddleware
{
	/**
	 * Call next handler when all is good or Response::error(...)
	 * 
	 * @param IHandler $handler
	 *
	 * @return IHandler
	 */
	public static function handle(IHandler $handler);
}
