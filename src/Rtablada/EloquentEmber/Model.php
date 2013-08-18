<?php namespace Rtablada\EloquentEmber;

class BaseModel extends Eloquent
{
	public function toEmberArray()
	{
		foreach ($this->with as $relation) {
			$collection = $this->$relation;
			$this->$relation = $collection->modelKeys();
		}

		return $this->attributesToArray();
	}

	public function newCollection(array $models = array())
	{
		return new EmberArrayCollection($models, $this->with);
	}

	public function toArray()
	{
		return $this->attributesToArray();
	}

	public function toArrayWithRelations()
	{
		return parent::toArray();
	}
}
