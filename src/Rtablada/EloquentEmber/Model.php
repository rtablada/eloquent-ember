<?php namespace Rtablada\EloquentEmber;

class Model extends \Illuminate\Database\Eloquent\Model
{
	public function toEmberArray()
	{
		foreach ($this->with as $relation) {
			$collection = $this->$relation;
			// If Plural
			if (substr($relation, -1) === 's') {
				$key = str_singular($relation);
				$this->attributes["{$key}_ids"] = $collection->modelKeys();
			} else {
				$this->attributes["{$relation}_id"] = $collection->modelKeys();
			}
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
