<?php

/**
 * Make a video iframe embed from a URL to a video.  Options supports the following:
 * id - The id of the element that will be created
 */
HTML::macro('vimeo', function($url, $width=500, $height=281, $options = null) {
	
	// Default options
	if (!$options) $options = array();
	$options = (object) array_merge(array(
		'id' => 'vimeo_player',
	), $options);
	
	// The video id is the last digits of the URL
	if (!preg_match('/(\d+)$/', $url, $matches)) return '';
	$video_id = $matches[0];
	
	// Return the assembled url
	return '<iframe id="'.$options->id.'" src="http://player.vimeo.com/video/'.$video_id.'?portrait=0&badge=0&title=0&byline=0&color=d76b00&api=1&player_id='.$options->id.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
});

// Make a Gravtar URL from an email
HTML::macro('gravatar', function($email) {
	return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email)));
});
