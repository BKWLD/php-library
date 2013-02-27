<?php

/**
 * Is like the unique validator but tests multiple columns.  All columns
 * must be the same for the validation to fail.  The syntax is the same as
 * unique except the multiple columns get seperated by semicolons.  Note, it
 * looks for the values of the other referenced 
 * 
 * Example:
 * array(
 * 	slug => 'unique_intersect:tags,slug;type,10'
 * )
 * 
 * Most of the code is copied verbatim from the unqiue validator
 */
Validator::register('unique_intersect', function($attribute, $value, $parameters) {
	
    // We allow the table column to be specified just in case the column does
		// not have the same name as the attribute. It must be within the second
		// parameter position, right after the database table name.
		if (isset($parameters[1])) {
			$attribute = $parameters[1];
		}

		$query = $this->db()->table($parameters[0])->where($attribute, '=', $value);

		// We also allow an ID to be specified that will not be included in the
		// uniqueness check. This makes updating columns easier since it is
		// fine for the given ID to exist in the table.
		if (isset($parameters[2])) {
			$id = (isset($parameters[3])) ? $parameters[3] : 'id';
			$query->where($id, '<>', $parameters[2]);
		}

		return $query->count() == 0;
});

// Return messages for all validators by executing `BKWLD\Laravel\Validator::messages()`
namespace BKWLD\Laravel;
class Validator {
	static public function messages() {
		return array(
			'unique_intersect' => Lang::line('validation.unique')->get();
		);
	}
}