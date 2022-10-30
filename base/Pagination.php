<?php

namespace tutfw\base;

use tutfw\base\Model;

class Pagination
{
	/**
	 * @param \tutfw\base\Model $model
	 * @param array $filter ['page', 'per_page', ...]
	 *
	 * @return array
	 */
	public static function handle(Model $model, array $filter = [])
	{
		$pagination['total_count'] = $model->count($filter);
		$pagination['per_page'] = (intval($filter['per_page'] ?? 10));
		$pagination['total_page'] = ceil($pagination['total_count'] / $pagination['per_page']);
		$pagination['current_page'] = (intval($filter['page'] ?? 1));

		return $pagination;
	}
}
