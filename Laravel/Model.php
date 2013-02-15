<?php namespace BKWLD\Laravel;

class Model {
	
	/**
	 * Convert all the model instances in a result set to arrays.  For use in
	 * making a JSON response from an Eloquent get()
	 */
	static public function eloquent_to_array($query) {
		return array_map(function($m) { return $m->to_array(); }, $query);
	}
	
	/**
	 * Convert a collection of models to an array of just their ids
	 */
	static public function ids($collection) {
		return array_map(function($model) {
			return $model->id;
		}, $collection);
	}
	
}