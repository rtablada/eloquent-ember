<?php namespace Rtablada\EloquentEmber;

class Model extends \Illuminate\Database\Eloquent\Model
{
	protected $withIds = array();

	public function toEmberArray($withWrap = true)
	{
		$relations = array_merge($this->withIds, $this->with);
		$sideloaded = $this->relationsToArray();
		$emberRelations = array();

		foreach ($relations as $relation) {
			$collection = $this->$relation;
			// If Plural
			if (substr($relation, -1) === 's') {
				$key = snake_case(str_singular($relation));
				$emberRelations["{$key}s"] = $collection->modelKeys();
			} else {
				$emberRelations["{$relation}"] = $collection->modelKeys();
			}
		}


		if (!$withWrap) {
			return array_merge($this->removeRelations($relations), $emberRelations);
		} else {
			return array_merge($this->sideloadRelated($relations, $sideloaded), $emberRelations);
		}
	}

	public function sideloadRelated($relations, $sideloaded)
	{
		$array = array($this->getModelKey() => $this->removeRelations($relations));

		return array_merge($array, $sideloaded);
	}

	public function removeRelations($relations)
	{
		$array = $this->toArray();

		foreach ($relations as $relation) {
			unset($array[$relation]);
		}

		return $array;
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
