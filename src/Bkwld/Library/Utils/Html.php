<?php namespace Bkwld\Library\Utils;

// Dependencies
use Illuminate\Support\Str;
use BKWLD\Library\APIs\Youtube;

// Utilities that assist in the generation of HTML
class Html {
	
	/**
	 * Make a vimeo iframe embed from a URL to a video.  Options supports the following:
	 * id - The id of the iframe (required)
	 * class - The class of the iframe
	 */
	static public function vimeo($url, $width=500, $height=281, $options = null) {
		
		// Default options
		if (!$options) $options = array();
		$options = (object) array_merge(array(
			'id' => Str::random(8, 'alpha'),
			'class' => 'vimeo_player',
		), $options);
		
		// The video id is the last digits of the URL
		if (!preg_match('/(\d+)$/', $url, $matches)) return '';
		$id = $matches[0];
		
		// Return the assembled url
		return '<iframe id="'.$options->id.'" src="//player.vimeo.com/video/'.$id.'?portrait=0&badge=0&title=0&byline=0&color=d76b00&api=1&player_id='.$options->id.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		
	}
	
	/**
	 * Make a youtube iframe embed from a URL to a video.  Options supports the following:
	 * id - The id of the iframe
	 * class - The class of the iframe
	 */
	static public function youtube($url, $width=500, $height=281, $options = null) {
		
		// Default options
		if (!$options) $options = array();
		$options = (object) array_merge(array(
			'id' => Str::random(8, 'alpha'),
			'class' => 'vimeo_player',
			'showinfo' => 0,
			'autohide' => 1,
			'rel' => 0,
		), $options);
		
		// Build params
		$params = http_build_query(array(
			'showinfo' => $options->showinfo,
			'autohide' => $options->autohide,
			'playerapiid' => $options->id,
			'rel' => $options->rel,
		));
		
		// Parse the ID from the youtube url
		if (!($id = Youtube\URL::id($url))) return '';
		
		// Return the assembled url
		return '<iframe id="'.$options->id.'" class="'.$options->class.'" width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$id.'?'.$params.'" frameborder="0" allowfullscreen></iframe>';
	}

	/**
	 * Make a gravatar image from an email
	 */
	static public function gravatar($email) {
		return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email)));
	}

	
}