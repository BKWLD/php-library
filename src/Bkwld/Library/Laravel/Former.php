<?php namespace Bkwld\Library\Laravel;

// Dependencies
use App;

/**
 * Functions for working with Former
 */
class Former {

	/**
	 * Take a key => value array like the type that is often used to store hard
	 * coded enum type data and turn it into the sort of array needed by
	 * Former's inline radio buttons.  Takes:
	 * 
	 * array(
	 *   'draft' => 'Draft', 
	 *   'pending' => 'Pending', 
	 *   'published' => 'Published',
	 * )
	 * 
	 * And makes:
	 * 
	 * array(
	 *   'Draft' => array('value' => 'draft', 'checked' => true),
	 *   'Pending' => array('value' => 'pending'),
	 *   'Published' => array('value' => 'published'),
	 * )
	 *
	 * @param  array $src An associative array
	 * @return array A multidimensional array like Former expects
	 */
	static public function radioArray($src) {
		$out = array();
		foreach($src as $key => $val) {
			if (!count($out)) $out[$val] = array('value' => $key, 'checked' => true);
			else $out[$val] = array('value' => $key);
		}
		return $out;
	}

	/**
	 * Take a key value array like described for radioArray and make a list of
	 * checkboxes that are named like an array.  In addition, it auto checks
	 * boxes on the edit view by looking to the former value
	 * 
	 * Thus, if used for the radio example might get an array like:
	 *
	 * array(
	 * 	 'Draft' => array('value' => 'draft', name => 'status[]', checked => false),
	 *   'Pending' => array('value' => 'pending', name='status[]', checked => true),
	 *   'Published' => array('value' => 'published', name='status[]', checked => false),
	 * )
	 *
	 * NOTE: You will need to flatten the input to a string manualy.  In Decoy, I do
	 * this with an onSaving() callback that looks like:
	 *
	 * public function onSaving() {
	 * 	if (is_array($this->status)) {
	 * 		$this->status = implode(',', array_filter($this->status));
	 * 	}
	 * }
	 * 
	 * NOTE: You will need to set `push(false)` on the checkbox to stop hidden
	 * fields from confusing the repopulation of the form on error.  Otherwise,
	 * something like this happens: http://cl.ly/image/3l1D32021q2I.  In addition
	 * you need to use this patch to Former that is currently waiting to be merged:
	 * https://github.com/Anahkiasen/former/pull/286
	 *
	 * @param  string $name The name of the form element (i.e. "status")
	 * @param  array $src An associative array
	 * @return array A multidimensional array like Former expects
	 */
	static public function checkboxArray($name, $src) {
		$out = array();
		$boxes = explode(',', App::make('former')->getValue($name));
		foreach($src as $key => $val) {
			$out[$val] = array(
				'value' => $key,
				'name' => $name.'[]',
				'checked' => in_array($key, $boxes),
			);
		}
		return $out;
	}

}
