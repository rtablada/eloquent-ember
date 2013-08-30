<?php namespace Rtablada\EloquentEmber;

class Model extends \Illuminate\Database\Eloquent\Model
{
	protected $withIds = array();

	public function toEmberArray($withWrap = true)
	{
		foreach ($this->withIds as $relation) {
			$collection = $this->$relation;
			// If Plural
			if (substr($relation, -1) === 's') {
				$key = str_singular($relation);
				$this->attributes["{$key}_ids"] = $collection->modelKeys();
			} else {
				$this->attributes["{$relation}_id"] = $collection->modelKeys();
			}
		}

		if (!$withWrap) {
			return $this->toArray();
		} else {
			return array($this->getModelKey() => $this->attributes, $relation => $this->$relation->toArray());
		}
	}

	public function newCollection(array $models = array())
	{
		return new Collection($models, $this->withIds, $this->getModelKey());
	}

	public function toArrayWithRelations()
	{
		return parent::toArray();
	}

	public function getModelKey()
	{
		return str_replace('\\', '', snake_case(class_basename($this)));
	}
}
