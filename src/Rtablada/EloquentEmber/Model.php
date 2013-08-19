<?php namespace Rtablada\EloquentEmber;

class Model extends \Illuminate\Database\Eloquent\Model
{
	public function toEmberArray()
	{
		foreach ($this->with as $relation) {
			$collection = $this->$relation;
			$this->attributes["{$relation}_ids"] = $collection->modelKeys();
		}

		return $this->attributesToArray();
	}

	public function newCollection(array $models = array())
	{
		return new Collection($models, $this->with);
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
