<?php namespace Bkwld\Library\Utils;

// Dependencies
use Lang;
require_once('vendor/kwi-urllinker/UrlLinker.class.php');
use Kwi\UrlLinker;

// Utilities for dealing with strings
class String {
	
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

	/**
	 * Replace the last whitespace in a string in a string with a &nbsp; to prevent orphans.
	 * Essentially makes the last two words wrap together.  Regexp inspired by:
	 * http://frightanic.wordpress.com/2007/06/08/regex-match-last-occurrence/
	 */
	static public function noOrphan($text) {
		if (substr_count($text, ' ') < 3) return $text; // Require > 3 words
		return preg_replace('#\s+(?!.*\s)#', '&nbsp;', $text);
	}

	/**
	 * Show a human timestamp for how much time has elapssed since the timestamp
	 * Adapted from http://www.zachstronaut.com/posts/2009/01/20/php-relative-date-time-string.html
	 */
	static public function timeElapsed($ptime, $options = null) {
		
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

	/**
	 * Convert a key / slug into a friendly title string
	 * @param string $keyword i.e. "some_multi_key"
	 * @return string i.e. "Some multi key"
	 */
	static public function titleFromKey($keyword) {
		
		// Check for the keyword in Laravel's translation system
		if (class_exists('Lang')) {
			if (Lang::has('admin.'.$keyword)) return Lang::get('admin.'.$keyword);
			if (Lang::has('application.'.$keyword)) return Lang::get('app.'.$keyword);
		}
		
		// Otherwise, auto format it
		return ucfirst(str_replace('_', ' ', $keyword));
	}
	
	/**
	 * Remove everything up the substring from a string.
	 * Ex: trimUntil('/var/www/site/public/uploads/01/01/file.jpg', '/uploads');
	 * @param string $str The string that we're trimming
	 * @param string $substr The string that indicates where to stop trimming
	 */
	static public function trimUntil($str, $substr) {
		$pos = strpos($str, $substr);
		if ($pos === false) return $str;
		return substr($str, $pos);
	}
}