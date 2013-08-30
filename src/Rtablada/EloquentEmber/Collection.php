<?php namespace Rtablada\EloquentEmber;

class Collection extends \Illuminate\Database\Eloquent\Collection
{
	public $modelKey;

	/**
	 * Temporary storing place for related models.
	 * 
	 * @var array;
	 */
	protected $relatives = [];

	/**
	 * Create a new collection.
	 *
	 * @param  array  $items
	 * @return void
	 */
	public function __construct(array $items = array(), $relations, $modelKey)
	{
		$this->items = $items;
		$this->relations = $relations;
		$this->modelKey = $modelKey;
	}

	public function toEmberArray()
	{
		$modelKey = $this->getModelKey();

		$items = array();

		// Setup the relationship keys.
		foreach ($this->relations as $relation)
		{
			$this->relatives[$relation] = [];
		}

		$this->each(function($model) use (&$items)
		{
			$model = $model->toEmberArray(false);

			// Loop over each relation and push them to the relatives array
			// to be merged with the result later.
			foreach ($this->relations as $relation)
			{
				if (count($model[$relation]) > 0)
				{
					foreach ($model[$relation] as $relative)
					{
						array_push($this->relatives[$relation], $relative);
					}
				}
				unset($model[$relation]);
			}

			$items[] = $model;
		});

		return array_merge(array($modelKey => $items), $this->relatives);
	}

	public function getModelKey()
	{
		return str_plural($this->modelKey);
	}
}
