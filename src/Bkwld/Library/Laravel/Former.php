<?php namespace Bkwld\Library\Laravel;

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
	 */
	static public function radioArray($src) {
		$out = array();
		foreach($src as $key => $val) {
			if (!count($out)) $out[$val] = array('value' => $key, 'checked' => true);
			else $out[$val] = array('value' => $key);
		}
		return $out;
	}

}