<?php namespace Rtablada\EloquentEmber;

class Collection extends \Illuminate\Database\Eloquent\Collection
{
	public $modelKey;

	/**
	 * Create a new collection.
	 *
	 * @param  array  $items
	 * @return void
	 */
	public function __construct(array $items = array(), $sideloads, $modelKey)
	{
		$this->items = $items;
		$this->sideloads = $sideloads;
		$this->modelKey = $modelKey;
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
		return str_plural($this->modelKey);
	}
}
