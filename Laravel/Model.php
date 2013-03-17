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
	
	/**
	 * Manual pagiantion.  This is useful when the built in pagination can't be
	 * used, which is the case when your query has a group by
	 */
	static public function paginate($query, $per_page) {
		return $query->take($per_page)->skip((\Laravel\Input::get('page', 1)-1)*$per_page);
	}
	
	/**
	 * Get the total count in a group_by friendly way.  count() can't be use because 
	 * of how group by's affect it. And only() can't be used to get the value because it
	 * can modify the $query object, restricting the columns that would get returned
	 * @param $query - An Eloquent query instance
	 * @param $table - The table you are counting
	 */
	static public function count($query, $table = null) {
		$column = $table ? $table.'.id' : 'id';
		return $query->select(array(\Laravel\Database::raw('COUNT(DISTINCT '.$column.') AS total')))->first()->total;
	}
	
}