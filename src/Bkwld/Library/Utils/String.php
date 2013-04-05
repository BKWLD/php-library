<?php namespace BKWLD\Library\Utils;

// Dependencies
require_once('vendor/kwi-urllinker/UrlLinker.class.php');
use \Kwi\UrlLinker;

// Utilities for dealing with strings
class String {

	/**
	 * Convert a key / slug into a friendly title string
	 * @param string $keyword i.e. "some_multi_key"
	 * @return string i.e. "Some multi key"
	 */
	static public function title_from_key($keyword) {
		
		// Check for the keyword in Laravel's translation system
		if (function_exists('__')) {
			if (\Laravel\Lang::has('admin.'.$keyword)) return __('admin.'.$keyword);
			if (\Laravel\Lang::has('application.'.$keyword)) return __('application.'.$keyword);
		}
		
		// Otherwise, auto format it
		return ucfirst(str_replace('_', ' ', $keyword));
	}
	
	/**
	 * Add HTML links to URLs in a string.  This loads a vendor PHP
	 * file into this function because it registers global functions
	 * that I don't want in the global space
	 */
	static public function linkify($text, $options = array()) {
		
		// Default options
		$defaults = array(
			'target' => '_blank',
		);
		
		// Apply user options
		if (is_array($options)) $options = array_merge($defaults, $options);
		
		// Generate the link
		$url_linker = new UrlLinker;
		return $url_linker->parse($text, $options);
	}
	
	// Show a human timestamp for how much time has elapssed since the timestamp
	// Adapted from http://www.zachstronaut.com/posts/2009/01/20/php-relative-date-time-string.html
	static public function time_elapsed($ptime, $options = null) {
		
		// Default options
		if (!$options) $options = array();
		$options = array_merge(array(
			'pluraling' => true,
			'spacing' => true,
			'labels' => array(
				'0 seconds',
				'second',
				'minute',
				'hour',
				'day',
				'month',
				'year',
			)
		), $options);
		
		$etime = time() - $ptime;
		if ($etime < 1) { return $options['labels'][0]; }
		
		$a = array( 12 * 30 * 24 * 60 * 60  =>  $options['labels'][6],
		            30 * 24 * 60 * 60       =>  $options['labels'][5],
		            24 * 60 * 60            =>  $options['labels'][4],
		            60 * 60                 =>  $options['labels'][3],
		            60                      =>  $options['labels'][2],
		            1                       =>  $options['labels'][1],
		            );
		
		foreach ($a as $secs => $str) {
			$d = $etime / $secs;
			if ($d >= 1) {
				$r = round($d);
				if ($options['pluraling']) return $r . ($options['spacing']?' ':'') . $str . ($r > 1 ? 's' : '');
				else return $r .($options['spacing']?' ':''). $str;
			}
		}
	}
	
}