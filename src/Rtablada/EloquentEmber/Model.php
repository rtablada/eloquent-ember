<?php namespace Rtablada\EloquentEmber;

class Model extends \Illuminate\Database\Eloquent\Model
{
	protected $withIds = array();

	public function toEmberArray($withWrap = true)
	{
		$relations = array_merge($this->withIds, $this->with);
		$sideloaded = $this->relationsToArray();

		foreach ($relations as $relation) {
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
			return $this->sideloadRelated($relations, $sideloaded);
		}
	}

	public function sideloadRelated($relations, $sideloaded)
	{
		$array = $this->toArray();

		foreach ($relations as $relation) {
			unset($array[$relation]);
		}

		$array = array($this->getModelKey() => $array);

		return array_merge($array, $sideloaded);
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
