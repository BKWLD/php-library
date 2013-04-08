<?php namespace Bkwld\Library\Laravel;

// Dependencies
use Input;
use Lang;
use Messages;
use Redirect;
use URL;
use Exception;
use Database as DB;

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
 * 	'slug' => 'unique_intersect:tags,type;category,slug,10'
 * )
 * 
 */
\Validator::register('unique_with', function($attribute, $value, $parameters) {
	
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

/**
 * Validating logic that doesn't make sense as a registered Laravel validator
 */
class Validator {
	
	/**
	 * Return messages for all validators by executing `BKWLD\Laravel\Validator::messages()`
	 */
	static public function messages() {
		return array(
			'unique_with' => Lang::line('validation.unique')->get(),
		);
	}
	
	/**
	 * To succeed, all but one of the referenced fields must be empty.  In other words, one and only one field must
	 * have a value.
	 * @param $fields An array containing the field names to check
	 * @param $input An associateive array of ht einput to check
	 * 
	 * Example: (this would be put in a Decoy model)
	 * public function on_validating($input) {
	 *	if ($response = BKWLD\Laravel\Validator::require_just_one(array('image', 'vimeo_url'), $input)) return $response;
	 *	parent::on_validating($input);
	 * }
	 * 
	 */
	static public function require_just_one($fields, $input = null) {
		
		// Input is optional
		if (empty($input)) $input == Input::get();
		
		// You must specify additional columns
		if (count($fields) <= 1) throw new Exception('Multiple fields must be specified');
		
		// Check for each parameter in the input
		$found = 0;
		foreach($fields as $field) {
			
			// Test if a file
			if (!empty($input[$field]['tmp_name'])) $found++;
			
			// Test if a normal field
			if (!empty($input[$field]) && !isset($input[$field]['tmp_name'])) $found++;
		}
		
		// If only one field has data, we're good.  Return false to indicate there is no error
		if ($found === 1) return false;

		// Otherwise, return a redirect response with the error
		$titles = array_map('\BKWLD\Utils\String::title_from_key', $fields);
		$message = 'You must specify <strong>exactly one</strong> of the following fields: '.implode(', ', $titles);
		$errors = new Messages();
		foreach($fields as $field) { $errors->add($field, $message); }
		return Redirect::to(URL::current())
			->with_errors($errors)
			->with_input();
		
	}
}