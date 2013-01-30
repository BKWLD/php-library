<?php namespace BKWLD\Laravel;

class Model {
	
	/**
	 * Convert all the model instances in a result set to arrays.  For use in
	 * making a JSON response from an Eloquent get()
	 */
	static public function eloquent_to_array($query) {
		return array_map(function($m) { return $m->to_array(); }, $query);
	}
	
}