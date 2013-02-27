<?php namespace BKWLD\Laravel;

// Dependencies
use \Laravel\Input;
use \Laravel\Lang;
use \Exception;
use \Laravel\Database as DB;

/**
 * Is like the unique validator but tests multiple columns.  All columns
 * must be the same for the validation to fail.  Note, it
 * looks for the values of the other referenced column from Input::get()
 * 
 * Params:
 * - Table name
 * - The other columns.  Semicolon delimited
 * - Optional column name of the attribute
 * - Optional id to ignore
 * - Optional column for id
 * 
 * Example:
 * array(
 * 	slug => 'unique_intersect:tags,type;category,slug,10'
 * )
 * 
 */
\Laravel\Validator::register('unique_with', function($attribute, $value, $parameters) {
	
    // You must specify additional columns
		if (!isset($parameters[0]) || !isset($parameters[1])) throw new Exception('Table and additional columns must be provided');

		// Optional column name for the attribtue
		if (isset($parameters[2])) {
			$attribute = $parameters[2];
		}

		// Form query
		$query = DB::table($parameters[0])->where($attribute, '=', $value);
		foreach(explode(';', $parameters[1]) as $column) {
			if (!Input::has($column)) throw new Exception('Column not found in input: '.$column);
			$query = $query->where($column, '=', Input::get($column));
		}

		// We also allow an ID to be specified that will not be included in the
		// uniqueness check. This makes updating columns easier since it is
		// fine for the given ID to exist in the table.
		if (isset($parameters[3])) {
			$id = (isset($parameters[4])) ? $parameters[4] : 'id';
			$query->where($id, '<>', $parameters[3]);
		}

		return $query->count() == 0;
});

// Return messages for all validators by executing `BKWLD\Laravel\Validator::messages()`
class Validator {
	static public function messages() {
		return array(
			'unique_with' => Lang::line('validation.unique')->get(),
		);
	}
}