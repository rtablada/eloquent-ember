<?php namespace Rtablada\EloquentEmber;

class Collection extends \Illuminate\Database\Eloquent\Collection
{
	/**
	 * Create a new collection.
	 *
	 * @param  array  $items
	 * @return void
	 */
	public function __construct(array $items = array(), $relations)
	{
		$this->items = $items;
		$this->relations = $relations;
	}

	public function toEmberArray()
	{
		$modelKey = $this->getModelKey();

		$items = array();

		$this->each(function($model) use (&$items)
		{
			$items[] = $model->toEmberArray(false);
		});

		return array($modelKey => $items);
	}

	public function getModelKey()
	{
		$first = $this->first();
		return str_plural($first->getModelKey());
	}
}
